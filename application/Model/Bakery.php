<?php

namespace Model;

class Bakery extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var string
     */
    protected $collection = 'bakeries';

    /**
     * @var array
     */
    protected $fields = array(
        'city' => '\Model\City',
        'delivery_price' => 'float',
    );
}
