<?php

namespace Api\Resources;

use Model\Cake;
use Model\Dimension;
use PhotoCake\App\Config;

class Cakes extends \Api\Resources\Resource
{
    /**
     * @param string $bakeryId
     * @param string $image
     * @param string $photo
     * @param \stdClass $markup
     * @return \Model\Cake
     */
    public function createCake($bakeryId, $image, $photo, \stdClass $markup)
    {
        $cake = $this->createRecord(\Model\Cake::NAME);
        $cake->setImageUrl($this->saveImage('cake_image_', $image));

        if (isset($markup->content->photo) &&
            $markup->content->photo->image_source === 'network') {

            $cake->setPhotoUrl($markup->content->photo->photo_url);
        } elseif (!empty($photo)) {
            $cake->setPhotoUrl($this->saveImage('cake_photo_', $photo));
        }

        $cake->setMarkup(json_encode($markup));
        $cake->setBakeryId($bakeryId);

        return $cake;
    }

    /**
     * @param \Model\Cake $cake
     */
    public function saveCake(\Model\Cake $cake) {
        $this->getCollection('cakes')->update($cake);
    }

    /**
     * @param string $id
     * @return Cake
     */
    public function getById($id) {
        return $this->getCollection('cakes')->fetch($id);
    }

    /**
     * @param int $count
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getPromotedCakes($count, $bakeryId)
    {
        return $this->getCollection('cakes')->fetchAll(array(
            'promoted_index' => array( '$exists' => true ),
            'bakery_id' => $bakeryId
        ), $count, 0, array( 'promoted_index' => 1 ));
    }


    /**
     * @param \Model\Cake $cake
     * @param int $index
     */
    public function addPromotedCake(Cake $cake, $index) {
        if ($cake->getPhotoUrl() !== null) {
            $markup = json_decode($cake->getMarkup());
            $markup->content->photo->image_source = 'network';
            $markup->content->photo->photo_url = $cake->getPhotoUrl();

            $cake->setMarkup(json_encode($markup));
        }

        $this->getCollection('cakes')->removeAll(array(
            'promoted_index' => $index,
            'bakery_id' => $cake->getBakeryId()
        ));

        $cake->setPromotedIndex($index);
        $this->saveCake($cake);
    }

    /**
     * @param string $prefix
     * @param string $data
     * @return null|string
     */
    private function saveImage($prefix, $data) {
        $id = uniqid($prefix);
        $fileName = $id . '.jpg';

        if (file_put_contents(Config::get('files.folder') . $fileName, $data)) {
            return Config::get('files.url') . $fileName;
        }

        return null;
    }


    /**
     * @static
     * @var \Api\Resources\Cakes
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Cakes
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Cakes();
        }

        return self::$instance;
    }
}
