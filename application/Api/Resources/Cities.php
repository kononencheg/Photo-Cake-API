<?php

namespace Api\Resources;

class Cities extends \Api\Resources\Resource
{
    /**
     * @param $id
     * @return \Model\City
     */
    public function getById($id)
    {
        return $this->getCollection('cities')->fetch($id);
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
