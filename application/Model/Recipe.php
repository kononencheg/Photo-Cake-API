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

        'dimention_prices' => array( 'type' => DimensionPrice::NAME,
                                     'relation' => MongoRecord::RELATION_MANY,
                                     'key_field' => 'dimension_id' ),
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
     * @return array
     */
    public function getDimentionPrices()
    {
        return $this->get('dimention_prices');
    }

    /**
     * @param DimensionPrice $dimentionPrice
     */
    public function addDimentionPrice(DimensionPrice $dimentionPrice)
    {
        return $this->add('dimention_prices', $dimentionPrice);
    }

    /**
     * @param DimensionPrice $dimentionPrice
     */
    public function removeDimentionPrice(DimensionPrice $dimentionPrice)
    {
        return $this->remove('dimention_prices', $dimentionPrice);
    }

    /**
     * @param string $dimentionId
     * @return DimensionPrice
     */
    public function getDimentionPrice($dimentionId)
    {
        $prices = $this->get('dimention_prices');
        return $prices[$dimentionId];
    }
}
