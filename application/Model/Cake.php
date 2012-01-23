<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class Cake extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var string
     */
    protected $collectionName = 'cakes';

    /**
     * @var array
     */
    protected $fields = array(
        'image_url' => 'string',
        'photo_url' => 'string',
        'markup' => 'string',
        'weight' => 'float',
    );

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('image_url', 'photo_url', 'weight', '_ref'),
    );
}
