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
    protected $fields = array(
        'markup' => 'string',

        'image_url' => 'string',
        'photo_url' => 'string',
        'dimension' => Dimension::NAME,
    );

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
    public function getContentMarkup()
    {
        return $this->get('content_markup');
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
}
