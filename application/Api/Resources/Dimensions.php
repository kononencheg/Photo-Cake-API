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
    public function createDimension($shape, $weight, $ratio, $personsCount)
    {
        $dimension = $this->createRecord(Dimension::NAME);
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
     * @return \Iterator
     */
    public function getDimensions()
    {
        return $this->getCollection('dimensions')->fetchAll();
    }

    /**
     * @param float $weight
     * @param string $shape
     * @return \Model\Dimension
     */
    public function getOne($weight, $shape)
    {
        return $this->getCollection('dimensions')->fetchOne(array(
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
