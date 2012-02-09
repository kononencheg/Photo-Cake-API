<?php

namespace Api\Methods\Orders;

use Model\Order;

use Api\Resources\Orders;
use Api\Resources\Clients;
use Api\Resources\Cakes;
use Api\Resources\Deliveries;
use Api\Resources\Payments;

use \PhotoCake\Api\Arguments\Filter;

class Submit extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'order_id' => array( Filter::STRING, array( null => 'Ошибка выбора заказа.' ) ),

        'client_email'      => array( Filter::EMAIL,  array( null => 'Email не задан.', false => 'Email введен не правильно.' ) ),
        'client_phone'      => array( Filter::PHONE,  array( null => 'Телефон не задан.', false => 'Телефон введен неправильно.' ) ),
        'client_name'       => array( Filter::STRING, array( null => 'Имя не задано.' ) ),
        'client_network'    => array( Filter::INTEGER ),
        'client_network_id' => array( Filter::STRING ),

        'delivery_time'    => array( Filter::INTEGER, array( -1 => 'Время не задано.' ) ),
        'delivery_date'    => array( Filter::STRING,  array( null => 'Дата не задана.' ) ),
        'delivery_address' => array( Filter::STRING,  array( null => 'Адрес не задан.' ) ),
        'delivery_message' => array( Filter::STRING ),
        'delivery_comment' => array( Filter::STRING ),

        'payment_method' => array( Filter::INTEGER,  array( null => 'Ошибка данных оплаты.' ) ),

        'submit_type' => array( Filter::STRING ),
    );

    /**
     * @return void
     */
    protected function filter()
    {
        $this->applyFilter($this->arguments, array(
            'date' => 'testDate'
        ));
    }

    protected function testDate($date)
    {
        $timestamp = Deliveries::getInstance()->filterDate
                                        ($date, $this->getParam('time'));

        if ($timestamp === -1) {
            $this->response->addParamError
                ('date', 'Срок обработки заказа минимум двое суток.');
        } elseif ($timestamp === null) {
            $this->response->addParamError
               ('date', 'Правильный формат даты "дд.мм.гггг".');
        } else {
            $this->setParam('delivery_date', $timestamp);
        }
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $orders = Orders::getInstance();

        $order = $orders->getById($this->getParam('order_id'));
        if ($order !== null) {
            $order->setClient($this->createClient());
            $order->setDelivery($this->createDelivery());
            $order->setStatus(Order::ORDER_SUBMIT);

            $orders->updatePaymentMethod
                ($order, $this->getParam('payment_method'));

            $orders->saveOrder($order);

            return $order->jsonSerialize();
        }

        return null;
    }

    /**
     * @return \Model\Delivery
     */
    private function createDelivery()
    {
        $deliveries = Deliveries::getInstance();
        $delivery = $deliveries->createDelivery(
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
        $clients = Clients::getInstance();
        $client = $clients->createClient(
            $this->getParam('client_email'),
            $this->getParam('client_name'),
            $this->getParam('client_phone'),
            $this->getParam('client_network'),
            $this->getParam('client_network_1d')
        );

        return $client;
    }

}
