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
    protected $accessList = array( User::ADMIN, User::BAKERY );

    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => Filter::STRING
    );

    protected function filter()
    {
        $users = Users::getInstance();

    	if ($users->getCurrentRole() === User::BAKERY) {
 			$this->setParam('bakery_id', $users->getCurrentUserId());
    	} else {
	        $this->applyFilter(array(
	            'bakery_id' => array
	            	( null => 'Идентификатор кондитерской не задан.' ),
	        ));
    	}
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        return Orders::getInstance()->getBakeryOrders($this->getParam('bakery_id'));
    }
}

