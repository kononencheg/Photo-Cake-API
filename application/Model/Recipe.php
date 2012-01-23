<?php

namespace Model;

class Recipe extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var string
     */
    protected $collectionName = 'recipes';

    /**
     * @var array
     */
    protected $fields = array(
        'name' => 'string',
        'title' => 'string',
        'desc' => 'string',
        'image_url' => 'string',
        'price' => 'float',
    );

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('title', 'desc', '_ref'),
    );
}
