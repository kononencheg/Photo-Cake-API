<?php

namespace Model;

class Payment extends \PhotoCake\Db\Mongo\MongoRecord
{
    const CASH = 'cash';

    /**
     * @var array
     */
    protected $fields = array(
        'deco_price' => 'float',
        'recipe_price' => 'float',
        'delivery_price' => 'float',
        'total_price' => 'float',
        'payment_type' => 'string'
    );
}
