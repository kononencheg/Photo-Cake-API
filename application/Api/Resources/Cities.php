<?php

namespace Api\Resources;

use Model\City;

class Cities extends \Api\Resources\Resource
{
    /**
     * @param string $name
     * @param int $timezoneOffset
     * @return \Model\City
     */
    public function createCity($name, $timezoneOffset)
    {
        $city = $this->createRecord(City::NAME);
        $city->setName($name);
        $city->setTimezoneOffset($timezoneOffset);

        return $city;
    }

    /**
     * @param \Model\City $dimension
     */
    public function saveCity(City $city)
    {
        $this->getCollection('cities')->update($city);
    }

    /**
     * @param $id
     * @return \Model\City
     */
    public function getById($id)
    {
        return $this->getCollection('cities')->fetch($id);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->getCollection('cities')->fetchAll();
    }

    /**
     * @static
     * @var \Api\Resources\Cities
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Cities
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Cities();
        }

        return self::$instance;
    }

}
