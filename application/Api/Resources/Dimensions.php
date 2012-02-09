<?php

namespace Api\Resources;

class Dimensions extends \Api\Resources\Resource
{

    /**
     * @param string $bakeryId
     * @param float $weight
     * @param string $shape
     * @return \Model\Dimensions
     */
    public function getByWeight($bakeryId, $weight, $shape)
    {
        return $this->getCollection('dimensions')->fetchOne(array(
            'bakery_id' => $bakeryId,
            'shape' => $shape,
            'weight' => $weight
        ));
    }


    /**
     * @static
     * @var \Api\Resources\Dimensions
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Dimensions
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Dimensions();
        }

        return self::$instance;
    }
}
