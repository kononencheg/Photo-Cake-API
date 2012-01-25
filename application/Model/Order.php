<?php

namespace Model;

class Order extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var string
     */
    protected $collection = 'orders';

    /**
     * @var array
     */
    protected $fields = array(
        'comment' => 'string',

        'cake'     => '\Model\Cake',
        'recipe'   => '\Model\Recipe',
        'client'   => '\Model\Client',
        'delivery' => '\Model\Delivery',
        'payment'  => '\Model\Payment',
    );
}
