<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class City extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'city';

    /**
     * @var string
     */
    protected $collection = 'cities';

    /**
     * @var array
     */
    protected $options = array(
        'name' => 'string',
        'timezone_offset' => 'int',
    );

    /**
     * @param int $timezoneOffset
     */
    public function setTimezoneOffset($timezoneOffset)
    {
        $this->set('timezone_offset', $timezoneOffset);
    }

    /**
     * @return int
     */
    public function getTimezoneOffset()
    {
        return $this->get('timezone_offset');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->set('name', $name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }
}
