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
        'message' => 'string',
        'campaign' => 'string',

        'cake'     => '\Model\Cake',
        'recipe'   => '\Model\Recipe',
        'client'   => '\Model\Client',
        'bakery'   => '\Model\Bakery',
        'payment'  => '\Model\Payment',
        'delivery' => '\Model\Delivery',
    );
}
