<?php

namespace Api\Resources;

class Recipes extends \PhotoCake\Api\Resource\DbResource
{
    private $collection = null;

    public function __construct()
    {
        parent::__construct();

        $this->collection = $this->getCollection('recipes');
    }

    /**
     * @param $name
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function getByName($bakeryId, $name)
    {
        $condition = array(
            'bakery_id' => $bakeryId,
            'name' => $name
        );

        return $this->collection->fetchOne($condition);
    }

    public function getList($bakeryId)
    {
        $condition = array(
            'bakery_id' => $bakeryId
        );

        return $this->collection->fetchAll($condition);
    }
}
