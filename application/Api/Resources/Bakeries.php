<?php

namespace Api\Resources;

class Bakeries extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @return \Iterator
     */
    public function getList()
    {
        return $this->getCollection('bakeries')->fetchAll();
    }
}
