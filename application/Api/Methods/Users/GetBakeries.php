<?php

namespace Api\Methods\Users;

use Api\Resources\Users;
use Model\User;

class GetBakeries extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Users::getInstance()->getBakeries();
        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}

