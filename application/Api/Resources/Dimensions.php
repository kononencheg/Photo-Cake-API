<?php

namespace Api\Resources;

use Model\Dimension;
use Model\DimensionPrice;

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
    public function createDimension($bakery_id, $shape, $weight, $ratio,
                                    $personsCount)
    {
        $dimension = $this->createRecord(Dimension::NAME);
        $dimension->setBakeryId($bakery_id);
        $dimension->setShape($shape);
        $dimension->setWeight($weight);
        $dimension->setRatio($ratio);
        $dimension->setPersonsCount($personsCount);

        return $dimension;
    }

    /**
     * @param float $weight
     * @param float $price
     * @return \Model\DimensionPrice
     */
    public function createDimensionPrice($weight, $price)
    {
        $dimensionPrice = $this->createRecord(DimensionPrice::NAME);
        $dimensionPrice->setWeight($weight);
        $dimensionPrice->setPrice($price);

        return $dimensionPrice;
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
     * @param string $id
     * @return \Model\Dimension
     */
    public function getById($id)
    {
        return $this->getCollection('dimensions')->fetch($id);
    }

    /**
     * @param string $id
     */
    public function removeById($id)
    {
        $this->getCollection('dimensions')->removeAll(array(
            '_id' => new \MongoId($id)
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
