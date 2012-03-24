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

        'delivery_time'    => array( Filter::INTEGER, array( -1 => 'Время не задано.' ) ),
        'delivery_date'    => array( Filter::STRING,  array( null => 'Дата не задана.' ) ),
        'delivery_address' => array( Filter::STRING,  array( null => 'Адрес не задан.' ) ),
        'delivery_message' => array( Filter::STRING ),
        'delivery_comment' => array( Filter::STRING ),

        'payment_method' => array( Filter::INTEGER,  array( null => 'Ошибка данных оплаты.' ) ),
    );

    /**
     * @return void
     */
    protected function filter()
    {
        $this->applyFilter(array( 'delivery_date' => 'testDate' ));
    }

    /**
     * @param string $date
     */
    protected function testDate($date)
    {
        $timestamp = Deliveries::getInstance()->testDate
            ($date, $this->getParam('delivery_time'));

        if ($timestamp === -1) {
            $this->response->addParamError
                ('delivery_date', 'Срок обработки заказа минимум двое суток.');
        } elseif ($timestamp === null) {
            $this->response->addParamError
                ('delivery_date', 'Правильный формат даты "дд.мм.гггг".');
        } else {
            $this->setParam('delivery_date', $timestamp);
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
                $payment = $this->createPayment($bakery, $cake, $recipe);
                $delivery = $this->createDelivery();
                $client = $this->createClient();

                $order = $orders->createOrder();

                $order->setPayment($payment);
                $order->setBakery($bakery);
                $order->setRecipe($recipe);
                $order->setCake($cake);
                $order->setClient($client);
                $order->setDelivery($delivery);

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
     * @return \Model\Payment
     */
    private function createPayment(\Model\Bakery $bakery, \Model\Cake $cake,
                                   \Model\Recipe $recipe)
    {
        $payments = Payments::getInstance();

        $payment = $payments->createPayment();

        $payment->setPaymentMethod($this->getParam('payment_method'));
        $payment->setDeliveryPrice($bakery->getDeliveryPrice());
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
