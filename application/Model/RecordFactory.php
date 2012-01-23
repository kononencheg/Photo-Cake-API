<?php

namespace Model;

class RecordFactory implements \PhotoCake\Db\Record\RecordFactoryInterface
{
    /**
     * @param string $collectionName
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    function create($collectionName)
    {
        switch ($collectionName) {
            case 'clients': return new Client();
            case 'cities': return new City();
            case 'orders': return new Order();
            case 'recipes': return new Recipe();
            case 'cakes': return new Cake();
        }

        return NULL;
    }

}
