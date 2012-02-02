<?php

namespace Model;

class Delivery extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var array
     */
    protected $fields = array(
        'date' => '\MongoDate',
        'address' => 'string',
    );
}
