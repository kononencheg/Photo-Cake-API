<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

class Recipe extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'recipe';

    /**
     * @var string
     */
    protected $collection = 'recipes';

    /**
     * @var array
     */
    protected $options = array(
        'bakery_id' => 'string',
        'image_url' => 'string',

        'name' => 'string',
        'desc' => 'string',

        'dimension_prices' => array( 'type' => DimensionPrice::NAME,
                                     'relation' => MongoRecord::RELATION_MANY,
                                     'key_field' => 'weight' ),
    );

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('name', 'desc', '_ref'),
    );

    /**
     * @param string $bakeryId
     */
    public function setBakeryId($bakeryId)
    {
        $this->set('bakery_id', $bakeryId);
    }

    /**
     * @return string
     */
    public function getBakeryId()
    {
        return $this->get('bakery_id');
    }

    /**
     * @param string $desc
     */
    public function setDesc($desc)
    {
        $this->set('desc', $desc);
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->get('desc');
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->set('image_url', $imageUrl);
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->get('image_url');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->set('name', $name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @param float $weight
     * @return DimensionPrice
     */
    public function getDimensionPriceByWeight($weight)
    {
        return $this->getByKey('dimension_prices', $weight);
    }

    /**
     * @param DimensionPrice $dimensionPrice
     */
    public function addDimensionPrice(DimensionPrice $dimensionPrice)
    {
        $this->add('dimension_prices', $dimensionPrice);
    }

    /**
     * @param DimensionPrice $dimensionPrice
     */
    public function removeDimensionPrice(DimensionPrice $dimensionPrice)
    {
        $this->remove('dimension_prices', $dimensionPrice);
    }
}
