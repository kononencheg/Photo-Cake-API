<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'dimension_shape'         => array( Filter::STRING,  array( null => 'Параметр не задан.' ) ),
        'dimension_ratio'         => array( Filter::FLOAT,   array( null => 'Параметр не задан.' ) ),
        'dimension_weight'        => array( Filter::FLOAT,   array( null => 'Параметр не задан.' ) ),
        'dimension_persons_count' => array( Filter::INTEGER, array( null => 'Параметр не задан.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $dimensions = Dimensions::getInstance();

        $dimension = $dimensions->createDimension(
            $this->getParam('dimension_shape'),
            $this->getParam('dimension_weight'),
            $this->getParam('dimension_ratio'),
            $this->getParam('dimension_persons_count')
        );

        $dimensions->saveDimension($dimension);

        return $dimension->jsonSerialize();
    }
}
