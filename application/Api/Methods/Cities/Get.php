<?php

namespace Api\Methods\Cities;

use Api\Resources\Cities;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $cities = Cities::getInstance();
        $list = $cities->getAll();

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
