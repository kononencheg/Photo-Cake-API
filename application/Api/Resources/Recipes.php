<?php

namespace Api\Resources;

class Recipes extends \Api\Resources\Resource
{
    /**
     * @param string $id
     * @return \Model\Recipe
     */
    public function getById($id)
    {
        return $this->getCollection('recipes')->fetch($id);
    }

    /**
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getList($bakeryId)
    {
        $condition = array(
            'bakery_id' => $bakeryId
        );

        return $this->getCollection('recipes')->fetchAll($condition);
    }

    /**
     * @static
     * @var \Api\Resources\Recipes
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Recipes
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Recipes();
        }

        return self::$instance;
    }
}
