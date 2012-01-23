<?php

namespace Model;

class Client extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var array
     */
    protected $fields = array(
        'email' => 'string',
        'name' => 'string',
        'network' => 'string',
        'network_id' => 'string',
        'phone' => 'string',
    );
}
