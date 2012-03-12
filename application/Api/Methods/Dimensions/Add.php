<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN );

    /**
     * @var array
     */
    protected $arguments = array(
        'shape'         => array( Filter::STRING,  array( null => 'Параметр не задан.' ) ),
        'ratio'         => array( Filter::FLOAT,   array( null => 'Параметр не задан.', '-1' => 'Неверный масштаб' ) ),
        'weight'        => array( Filter::FLOAT,   array( null => 'Параметр не задан.', '-1' => 'Неверный вес' ) ),
        'persons_count' => array( Filter::INTEGER, array( null => 'Параметр не задан.', '-1' => 'Неверное число людей' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $dimensions = Dimensions::getInstance();

        $dimension = $dimensions->createDimension(
            $this->getParam('shape'),
            $this->getParam('weight'),
            $this->getParam('ratio'),
            $this->getParam('persons_count')
        );

        $dimensions->saveDimension($dimension);

        return $dimension->jsonSerialize();
    }
}
