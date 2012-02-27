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
        'weight' => 'float',
        'price' => 'float',
    );

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->set('price', $price);
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->get('price');
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->set('weight', $weight);
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->get('weight');
    }

}
