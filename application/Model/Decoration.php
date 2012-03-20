<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class Decoration extends \PhotoCake\Db\Mongo\MongoRecord
{

    /**
     * @const
     * @var string
     */
    const NAME = 'decoration';

    /**
     * @var string
     */
    protected $collection = 'decorations';

    /**
     * @var array
     */
    protected $options = array(
        'name' => 'string',
        'image_url' => 'string',
        'group' => 'integer',
        'is_autorotate' => 'boolean',
    );

    /**
     * @param string $bakeryId
     */
    public function setBakeryId($bakeryId)
    {
        $this->set('bakery_id', $bakeryId);
    }

    /**
     * @return string
     */
    public function getBakeryId()
    {
        return $this->get('bakery_id');
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->set('image_url', $imageUrl);
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->get('image_url');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->set('name', $name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @param integer $group
     */
    public function setGroup($group)
    {
        $this->set('group', $group);
    }

    /**
     * @return integer
     */
    public function getGroup()
    {
        return $this->get('group');
    }

    /**
     * @param boolean $isAutorotate
     */
    public function setAutorotate($isAutorotate)
    {
        $this->set('is_autorotate', $isAutorotate);
    }

    /**
     * @return boolean
     */
    public function isAutorotate()
    {
        return $this->get('is_autorotate');
    }
}
