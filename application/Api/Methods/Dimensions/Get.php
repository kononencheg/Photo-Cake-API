<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Dimensions;

use \PhotoCake\Api\Arguments\Filter;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Dimensions::getInstance()->getDimensions();
        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
