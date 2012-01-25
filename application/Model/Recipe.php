<?php

namespace Model;

class Recipe extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var array
     */
    protected $fields = array(
        'name' => 'string',
        'desc' => 'string',
        'price' => 'float',
        'image_url' => 'string',
        'bakery_id' => 'string',
    );
}
