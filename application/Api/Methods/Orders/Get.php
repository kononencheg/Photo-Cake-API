<?php

namespace Api\Methods\Orders;

use Api\Resources\Orders;
use Api\Resources\Users;

use Model\Order;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN, User::ROLE_BAKERY, User::ROLE_PARTNER );

    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Идентификатор кондитерской не задан.' ) ),
        'partner_id' => array( Filter::STRING ),
    );

    protected function prepare()
    {
        $users = Users::getInstance();
        $role = $users->getCurrentRole();

    	if ($role === User::ROLE_BAKERY) {
 			$this->setParam('bakery_id', $users->getCurrentUserId());
    	} elseif ($role === User::ROLE_PARTNER) {
            $this->setParam('partner_id', $users->getCurrentUserId());
        }
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Orders::getInstance()->getBakeryOrders
                ($this->getParam('bakery_id'), $this->getParam('partner_id'));

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;

    }
}

