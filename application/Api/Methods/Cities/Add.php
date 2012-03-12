<?php

namespace Api\Methods\Cities;

use Api\Resources\Cities;

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
        'timezone_offset' => array( Filter::INTEGER,  array( null => 'Параметр не задан.' ) ),
        'name'            => array( Filter::STRING,   array( null => 'Параметр не задан.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $cities = Cities::getInstance();

        $city = $cities->createCity(
            $this->getParam('name'),
            $this->getParam('timezone_offset')
        );

        $cities->saveCity($city);

        return $city->jsonSerialize();
    }
}
