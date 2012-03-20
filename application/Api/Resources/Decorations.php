<?php

namespace Api\Resources;

use Model\Decoration;
use Model\DecorationPrice;

class Decorations extends \Api\Resources\Resource
{
    /**
     * @param string $name
     * @param integer $group
     * @param string $imageUrl
     * @param boolean $isAutorotate
     * @return \Model\Decoration
     */
    public function createDecoration($name, $group, $imageUrl, $isAutorotate)
    {
        $decoration = $this->createRecord(Decoration::NAME);
        $decoration->setName($name);
        $decoration->setGroup($group);
        $decoration->setImageUrl($imageUrl);
        $decoration->setAutorotate($isAutorotate);

        return $decoration;
    }

    /**
     * @param string $decorationId
     * @param float $price
     * @return \Model\DecorationPrice
     */
    public function createDecorationPrice($decorationId, $price) {
        $decorationPrice = $this->createRecord(DecorationPrice::NAME);
        $decorationPrice->setDecorationId($decorationId);
        $decorationPrice->setPrice($price);

        return $decorationPrice;
    }

    /**
     * @param \Model\Decoration $decoration
     */
    public function saveDecoration(Decoration $decoration)
    {
        $this->getCollection('decorations')->update($decoration);
    }

    /**
     * @return \Iterator
     */
    public function getAll()
    {
        return $this->getCollection('decorations')->fetchAll();
    }

    /**
     * @param string $id
     * @return \Model\Dimension
     */
    public function getById($id)
    {
        return $this->getCollection('decorations')->fetch($id);
    }

    /**
     * @param string $id
     */
    public function removeById($id)
    {
        $this->getCollection('decorations')->removeAll(array(
            '_id' => new \MongoId($id)
        ));
    }

    /**
     * @static
     * @var \Api\Resources\Decorations
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Decorations
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Decorations();
        }

        return self::$instance;
    }
}
