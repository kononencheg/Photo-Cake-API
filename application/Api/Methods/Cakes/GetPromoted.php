<?php

namespace Api\Methods\Cakes;

use Api\Resources\Orders;
use Api\Resources\Users;
use Api\Resources\Cakes;

use Model\Order;
use Model\User;
use Model\Cake;

class GetPromoted extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Cakes::getInstance()->getPromotedCakes(9);
        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;

    }
}

