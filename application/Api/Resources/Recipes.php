<?php

namespace Api\Resources;

class Recipes extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param $name
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function getByName($name)
    {
        return $this->getCollection('recipes')->fetchOne(array('name' => $name));
    }

    public function getList()
    {
        return $this->getCollection('recipes')->fetchAll();
    }
}
