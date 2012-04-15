<?php

namespace Api\Methods\Cakes;

use PhotoCake\Api\Arguments\Filter;

use Api\Resources\Orders;
use Api\Resources\Users;
use Api\Resources\Cakes;

use Model\Order;
use Model\User;
use Model\Cake;

class GetPromoted extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Не задан идентификатор кондитерской.' ) )
    );


    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Cakes::getInstance()->getPromotedCakes(9, $this->getParam('bakery_id'));
        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;

    }
}

