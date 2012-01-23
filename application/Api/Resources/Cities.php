<?php

namespace Api\Resources;

class Cities extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param $id
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function getById($id)
    {
        return $this->getCollection('cities')->fetch($id);
    }

    public function getList()
    {
        return $this->getCollection('cities')->fetchAll();
    }
}
