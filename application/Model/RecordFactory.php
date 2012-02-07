<?php

namespace Model;

class RecordFactory implements \PhotoCake\Db\Record\RecordFactoryInterface
{
    /**
     * @param string $collection
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    function create($collection)
    {
        switch ($collection) {
            case 'bakeries': return new Bakery();
            case 'cities':   return new City();
            case 'orders':   return new Order();
            case 'users':    return new User();
        }

        return null;
    }

}
