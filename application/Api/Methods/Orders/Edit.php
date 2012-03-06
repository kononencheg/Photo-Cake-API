<?php

namespace Api\Methods\Orders;

use Model\Order;

use Api\Resources\Orders;

use \PhotoCake\Api\Arguments\Filter;

class Edit extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'id' => array( Filter::STRING, array( null => 'Не задан идентификатор заказа.' ) ),

        'status' => array( array( Order::ORDER_NEW,
                                  Order::ORDER_APPROVED,
                                  Order::ORDER_DECLINED ), array( null => 'Не существующий статус заказа.' ) ),

        'delivery_status' => array( array( Order::DELIVERY_NEW,
                                           Order::DELIVERY_PROCESS,
                                           Order::DELIVERY_COMPLETE ), array( null => 'Не существующий статус доставки.' ) ),

        'payment_status' => array( array( Order::PAYMENT_NEW,
                                          Order::PAYMENT_PAID ),  array( null => 'Не существующий статус оплаты.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $orders = Orders::getInstance();

        $order = $orders->getById($this->getParam('id'));
        if ($order !== null) {
            $order->setStatus($this->getParam('status'));
            $order->setPaymentStatus($this->getParam('payment_status'));
            $order->setDeliveryStatus($this->getParam('delivery_status'));

            $orders->saveOrder($order);

            $result = $order->jsonSerialize();
        } else {
            $this->response
                 ->addError('Заказ с идентификатором "' . $this->getParam('id') . '" не найден.', 100);
        }

        return $result;
    }


}
