<?php

namespace Api\Methods\Orders;

use PhotoCake\Http\Response\Format\RawFormat;

use Api\Resources\Orders;
use Api\Resources\Users;

use Model\Order;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class ForPrint extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    //protected $accessList = array( User::ROLE_ADMIN, User::ROLE_BAKERY );

    /**
     * @var array
     */
    protected $arguments = array(
        'id' => array( Filter::STRING, array( null => 'Идентификатор не задан.' ) )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $format = new RawFormat();
        $format->setMimeType('text/html');

        $this->response->setFormat($format);

        $orders = Orders::getInstance();
        $order = $orders->getById($this->getParam('id'));

        if ($order !== null) {
            $result = $orders->printOrder($order);
        } else {
            $this->response->addError('Заказ не найден.', 100);
        }

        return $result;
    }
}

