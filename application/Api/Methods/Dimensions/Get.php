<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Dimensions;

use \PhotoCake\Api\Arguments\Filter;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Параметр не задан.' ) )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Dimensions::getInstance()->getBakeryDimensions
                                            ($this->getParam('bakery_id'));

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
