<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class Dimensions extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'dimension';

    /**
     * @const
     * @var int
     */
    const SHAPE_ROUND = 0;

    /**
     * @const
     * @var int
     */
    const SHAPE_RECT = 1;

    /**
     * @var array
     */
    protected $fields = array(
        'shape' => 'int',
        'ratio' => 'float',
        'weight' => 'float',
        'persons_count' => 'int',
    );

    /**
     * @var array
     */
    protected $spanFields = array(
        'cakes' => array('weight', '_ref'),
    );

    /**
     * @param int $shape
     */
    public function setShape($shape)
    {
        $this->set('shape', $shape);
    }

    /**
     * @return int
     */
    public function getShape()
    {
        return $this->get('shape');
    }

    /**
     * @param float $ratio
     */
    public function setRatio($ratio)
    {
        $this->set('ratio', $ratio);
    }

    /**
     * @return float
     */
    public function getRatio()
    {
        return $this->get('ratio');
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

    /**
     * @param int $personsCount
     */
    public function setPersonsCount($personsCount)
    {
        $this->set('persons_count', $personsCount);
    }

    /**
     * @return int
     */
    public function getPersonsCount()
    {
        return $this->get('persons_count');
    }
}
