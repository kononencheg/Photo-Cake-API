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

        $recipe = Recipes::getInstance()->getById($this->getParam('recipe_id'));
        $bakery = Users::getInstance()->getById($this->getParam('bakery_id'));
        $cake = $cakes->getById($this->getParam('cake_id'));

        if ($this->getParam('delivery_address') === 'to title') {

            if ($cake->getPhotoUrl() !== null) {
                $markup = json_decode($cake->getMarkup());
                $markup->content->photo->image_source = 'network';
                $markup->content->photo->photo_url = $cake->getPhotoUrl();

                $cake->setMarkup(json_encode($markup));
            }

            $cake->setPromoted(true);
            $cakes->saveCake($cake);

        } else {
            if ($recipe !== null && $cake !== null && $bakery !== null) {
                $order = $orders->createOrder();
                $delivery = $this->createDelivery();

                $order->setBakery($bakery);
                $order->setRecipe($recipe);
                $order->setCake($cake);
                $order->setClient($this->createClient());
                $order->setDelivery($delivery);
                $order->setPayment
                    ($this->createPayment($bakery, $cake, $recipe, $delivery));

                $orders->saveOrder($order);
                $orders->emailOrder($order);

                $result = $order->jsonSerialize();
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
            $this->getParam('client_phone'),
            $this->getParam('client_network')
        );

        return $client;
    }

}
