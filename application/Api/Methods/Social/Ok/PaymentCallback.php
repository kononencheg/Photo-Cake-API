<?php

namespace Api\Methods\Social\Ok;

use PhotoCake\Api\Arguments\Filter;
use PhotoCake\App\Config;

use Api\Resources\Orders;

use Model\Order;
use Model\Payment;

class PaymentCallback extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'method' => array( Filter::STRING ),
        'application_key' => array( Filter::STRING ),
        'call_id' => array( Filter::STRING ),
        'sig' => array( Filter::STRING ),
        'uid' => array( Filter::STRING ),
        'amount' => array( Filter::FLOAT ),
        'transaction_time' => array( Filter::FLOAT ),
        'product_code' => array( Filter::STRING ),
        'transaction_id' => array( Filter::FLOAT ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $orders = Orders::getInstance();
        $transactionId = $this->getParam('transaction_id');

        if ($orders->checkTransactionId($transactionId)) {
            $orderId = $this->getParam('product_code');
            $order = $orders->getById($orderId);

            if ($order !== null) {
                $order->getPayment()->setPaymentMethod(Payment::METHOD_OK);
                $order->getPayment()->setTransactionId($transactionId);
                $order->setPaymentStatus(Order::PAYMENT_PAID);

                $orders->saveOrder($order);

                return '<callbacks_payment_response xmlns="http://api.forticom.com/1.0/">true</callbacks_payment_response>';
            }
        }

        header('invocation-error: 1001');

        return '<?xml version="1.0" encoding="UTF-8"?>
                <ns2:error_response xmlns:ns2="http://api.forticom.com/1.0/"><error_code>1001</error_code>
                    <error_msg>CALLBACK_INVALID_PAYMENT : Payment is invalid and can not be processed</error_msg>
                </ns2:error_response>';
    }
}

