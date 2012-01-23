<?php

namespace Api\Methods\Recipes;

use \PhotoCake\Api\Arguments\Filter;

class GetList extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $recipes = new \Api\Resources\Recipes();
        $list = $recipes->getList();

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
