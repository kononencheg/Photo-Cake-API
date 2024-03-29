<?php

namespace Api\Methods\Dimensions;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use Model\User;
use Model\Dimension;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN, User::ROLE_BAKERY );

    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Ошибка выбора кондитерской.' ) ),

        'shape'         => array( Filter::STRING,  array( null => 'Параметр не задан.' ) ),
        'size'          => array( Filter::FLOAT,   array( null => 'Параметр не задан.', '-1' => 'Неверный размер' ) ),
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
            $this->getParam('bakery_id'),
            $this->getParam('shape'),
            $this->getParam('weight'),
            Dimension::BASE_SIZE / $this->getParam('size'),
            $this->getParam('persons_count')
        );

        try {
            $dimensions->saveDimension($dimension);
        } catch (\Exception $error) {
            switch ($error->getCode()) {
                case 11000: {
                    $this->response->addError('Размер с такими параметрами уже существует!', 100);
                    break;
                }
                default: $this->response->addError('Ошибка записи в базу!', 100);
            }
        }


        return $dimension->jsonSerialize();
    }
}
