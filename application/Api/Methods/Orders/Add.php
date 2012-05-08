<?php

namespace Api\Methods\Orders;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;
use Api\Resources\Deliveries;
use Api\Resources\Clients;

use Model\Order;
use Model\Delivery;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Ошибка выбора кондитерской.' ) ),
        'recipe_id' => array( Filter::STRING, array( null => 'Ошибка выбора рецепта.' ) ),
        'cake_id'   => array( Filter::STRING, array( null => 'Подождите пока загрузится торт.' ) ),

        'partner_id'   => array( Filter::STRING ),

        'client_email'   => array( Filter::EMAIL/*,  array( null => 'Email не задан.', false => 'Email введен не правильно.' )*/ ),
        'client_phone'   => array( Filter::PHONE,  array( null => 'Телефон не задан.', false => 'Телефон введен неправильно.' ) ),
        'client_name'    => array( Filter::STRING, array( null => 'Имя не задано.' ) ),
        'client_network' => array( Filter::INTEGER ),

        'delivery_is_pickup' => array( Filter::BOOLEAN ),
        'delivery_time'    => array( Filter::INTEGER, array( -1 => 'Время не задано.' ) ),
        'delivery_date'    => array( Filter::STRING,  array( null => 'Дата не задана.' ) ),
        'delivery_address' => array( Filter::STRING ),
        'delivery_message' => array( Filter::STRING ),
        'delivery_comment' => array( Filter::STRING ),

        'payment_method' => array( Filter::INTEGER,  array( null => 'Ошибка данных оплаты.' ) ),
    );

    /**
     * @return void
     */
    protected function filter()
    {
        $this->applyFilter(array(
            'delivery_date' => 'testDate',
            'delivery_address' => 'testAddress'
        ));
    }

    /**
     * @param string $date
     */
    protected function testDate($date)
    {
        $timestamp = Deliveries::getInstance()->testDate
            ($date, $this->getParam('delivery_time'));

        if ($timestamp === null) {
            $this->response->addParamError
                ('delivery_date', 'Срок обработки заказа минимум двое суток.');
        } elseif ($timestamp === -1) {
            $this->response->addParamError
                ('delivery_date', 'Правильный формат даты "дд.мм.гггг".');
        } else {
            $this->setParam('delivery_date', $timestamp);
        }
    }

    /**
     * @param string $address
     */
    protected function testAddress($address)
    {

        if ($address === null && !$this->getParam('delivery_is_pickup')) {
            $this->response->addParamError
                ('delivery_address', 'Адрес не задан.');
        }
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $orders = Orders::getInstance();
        $cakes = Cakes::getInstance();
        $users = Users::getInstance();

        $recipe = Recipes::getInstance()->getById($this->getParam('recipe_id'));
        $bakery = $users->getById($this->getParam('bakery_id'));
        $cake = $cakes->getById($this->getParam('cake_id'));

        if (stripos($this->getParam('delivery_address'), 'to title:') === 0) {
            $titleAddress =
                explode('to title:', $this->getParam('delivery_address'));

            $index = $titleAddress[1];
            if ($index !== null) {
                $cakes->addPromotedCake($cake, (int) $index);
            }

        } else {
            if ($recipe !== null && $cake !== null && $bakery !== null) {
                $order = $orders->createOrder();
                $delivery = $this->createDelivery();

                $order->setBakery($bakery);
                $order->setIndex($bakery->getLastOrderIndex());
                $bakery->incrementLastOrderIndex();

                $order->setRecipe($recipe);
                $order->setCake($cake);
                $order->setClient($this->createClient());
                $order->setDelivery($delivery);
                $order->setPayment
                    ($this->createPayment($bakery, $cake, $recipe, $delivery));

                $partnerId = $this->getParam('partner_id');
                if ($partnerId !== null) {
                    $partner = $users->getById($partnerId);

                    if ($partner !== null) {
                        $order->setPartner($partner);
                    } else {
                        $this->response
                             ->addError('Неизвестный партнер.', 100);
                    }
                }

                if (!$this->response->hasErrors()) {
                    $orders->saveOrder($order);
                    $users->saveUser($bakery);

                    $orders->emailOrder($order);

                    $result = $order->jsonSerialize();
                }
            } else {
                $this->response
                     ->addError('Ошибка обработки данных заказа.', 100);
            }
        }

        return $result;
    }

    /**
     * @param \Model\Bakery $bakery
     * @param \Model\Cake $cake
     * @param \Model\Recipe $recipe
     * @param \Model\Delivery $delivery
     * @return \Model\Payment
     */
    private function createPayment(\Model\Bakery $bakery, \Model\Cake $cake,
                                   \Model\Recipe $recipe, Delivery $delivery)
    {
        $payments = Payments::getInstance();

        $payment = $payments->createPayment();

        $payment->setPaymentMethod($this->getParam('payment_method'));

        if ($delivery->getType() !== Delivery::TYPE_PICKUP) {
            $payment->setDeliveryPrice($bakery->getDeliveryPrice());
        }

        $payment->setRecipePrice(
            $payments->getRecipePrice($recipe, $cake->getDimension())
        );

        $payment->setDecorationPrice(
            $payments->getDecorationPrice($bakery, $cake->getMarkup())
        );

        return $payment;
    }

    /**
     * @return \Model\Delivery
     */
    private function createDelivery()
    {
        $delivery = Deliveries::getInstance()->createDelivery(
            $this->getParam('delivery_is_pickup') ?
                Delivery::TYPE_PICKUP : Delivery::TYPE_COURIER,
            $this->getParam('delivery_date'),
            $this->getParam('delivery_address'),
            $this->getParam('delivery_comment'),
            $this->getParam('delivery_message')
        );

        return $delivery;
    }

    /**
     * @return \Model\Client
     */
    private function createClient()
    {
        $client = Clients::getInstance()->createClient(
            $this->getParam('client_email'),
            $this->getParam('client_name'),
            $this->getParam('client_phone')
        );

        return $client;
    }

}
