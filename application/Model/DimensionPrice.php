<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class DimensionPrice extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'dimension-price';

    /**
     * @var array
     */
    protected $options = array(
        'dimension_id' => 'string',
        'hello' => 'string',
        'price' => 'float',
    );

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->set('price', $price);
        $this->set('hello', 'heloooooooooooo');
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->get('price');
    }

    /**
     * @param string $dimensionId
     */
    public function setDimensionId($dimensionId)
    {
        $this->set('dimension_id', $dimensionId);
    }

    /**
     * @return string
     */
    public function getDimensionId()
    {
        return $this->get('dimension_id');
    }

}
