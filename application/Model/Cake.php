<?php

namespace Model;

use \PhotoCake\Db\Record\AbstractRecord;

class Cake extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'cake';

    /**
     * @var string
     */
    protected $collection = 'cakes';

    /**
     * @var array
     */
    protected $options = array(
        'markup' => 'string',

        'image_url' => 'string',
        'photo_url' => 'string',
        'dimension' => Dimension::NAME,

        'promoted_index' => 'int',
        'bakery_id' => 'string',
    );

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('image_url', 'photo_url', 'dimension', '_ref'),
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
     * @param string $markup
     */
    public function setMarkup($markup)
    {
        $this->set('markup', $markup);
    }

    /**
     * @return string
     */
    public function getMarkup()
    {
        return $this->get('markup');
    }

    /**
     * @param string $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->set('photo_url', $photoUrl);
    }

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->get('photo_url');
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
     * @param \Model\Dimension $dimensions
     */
    public function setDimension(\Model\Dimension $dimension)
    {
        $this->set('dimension', $dimension);
    }

    /**
     * @return \Model\Dimension
     */
    public function getDimension()
    {
        return $this->get('dimension');
    }

    /**
     * @param int $isPromoted
     */
    public function setPromotedIndex($isPromoted)
    {
        $this->set('promoted_index', $isPromoted);
    }

    /**
     * @return int
     */
    public function getPromotedIndex()
    {
        return $this->get('promoted_index');
    }
}
