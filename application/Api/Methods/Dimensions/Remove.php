<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Dimensions;

use PhotoCake\Api\Arguments\Filter;

use PhotoCake\App\Config;

class Remove extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'id' => array( Filter::STRING, array( null => 'Параметр не задан.' ) )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        Dimensions::getInstance()->removeById($this->getParam('id'));

        return true;
    }
}
