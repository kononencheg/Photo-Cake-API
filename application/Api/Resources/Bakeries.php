<?php

namespace Api\Resources;

class Bakeries extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param $id
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function getById($id)
    {
        return $this->getCollection('bakeries')->fetch($id);
    }

    /**
     * @return \Iterator
     */
    public function getList()
    {
        return $this->getCollection('bakeries')->fetchAll();
    }
}
