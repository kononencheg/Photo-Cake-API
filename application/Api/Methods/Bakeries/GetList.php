<?php

namespace Api\Methods\Bakeries;

class GetList extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $bakeries = new \Api\Resources\Bakeries();
        $list = $bakeries->getList();

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
