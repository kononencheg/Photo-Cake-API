<?php

namespace Api\Resources;

use Model\Dimension;

class Dimensions extends \Api\Resources\Resource
{
    /**
     * @param string $bakeryId
     * @param string $shape
     * @param float $weight
     * @param float $ratio
     * @param int $personsCount
     * @return \Model\Dimension
     */
    public function createDimension($bakeryId, $shape, $weight, $ratio,
                                    $personsCount)
    {
        $dimension = $this->createRecord(Dimension::NAME);
        $dimension->setBakeryId($bakeryId);
        $dimension->setShape($shape);
        $dimension->setWeight($weight);
        $dimension->setRatio($ratio);
        $dimension->setPersonsCount($personsCount);

        return $dimension;
    }

    /**
     * @param \Model\Dimension $dimension
     */
    public function saveDimension(Dimension $dimension)
    {
        $this->getCollection('dimensions')->update($dimension);
    }

    /**
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getBakeryDimensions($bakeryId)
    {
        return $this->getCollection('dimensions')->fetchAll(array(
            'bakery_id' => $bakeryId
        ));
    }

    /**
     * @param string $bakeryId
     * @param float $weight
     * @param string $shape
     * @return \Model\Dimension
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
