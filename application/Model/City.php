<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class City extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @var string
     */
    protected $collection = 'cities';

    /**
     * @var array
     */
    protected $fields = array(
        'name' => 'string',
        'timezone_offset' => 'int',
    );
}
