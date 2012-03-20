<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class DecorationPrice extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'decoration-price';

    /**
     * @var array
     */
    protected $options = array(
        'decoration_id' => 'string',
        'price' => 'float',
    );

    /**
     * @param string $id
     */
    public function setDecorationId($id)
    {
        $this->set('decoration_id', $id);
    }

    /**
     * @return float
     */
    public function getDecorationId()
    {
        return $this->get('decoration_id');
    }

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

}
