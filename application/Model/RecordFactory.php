<?php

namespace Model;

class RecordFactory implements \PhotoCake\Db\Record\RecordFactoryInterface
{
    /**
     * @param string $collection
     * @param array $value
     * @return Admin|Bakery|City|Order|null
     */
    function createForCollection($collection, array $value)
    {
        switch ($collection) {
            case 'bakeries': return new Bakery();
            case 'cities':   return new City();
            case 'orders':   return new Order();
            case 'users': {
                switch ($value['role']) {
                    case User::ROLE_ADMIN: return new Admin();
                    case User::ROLE_BAKERY: return new Bakery();
                }
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @param array $value
     * @return Admin|Bakery|City|Order|null
     */
    function createByName($name, array $value)
    {

    }
}
