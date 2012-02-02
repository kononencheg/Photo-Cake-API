<?php

namespace Model;

class Client extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var array
     */
    protected $fields = array(
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'network' => 'string',
        'user_id' => 'string',
    );
}
