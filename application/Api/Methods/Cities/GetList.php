<?php

namespace Api\Methods\Cities;

class GetList extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $cities = new \Api\Resources\Cities();
        $list = $cities->getList();

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
