<?php

namespace Api\Resources;

use Model\Dimensions;
use PhotoCake\App\Config;

class Cakes extends \Api\Resources\Resource
{
    /**
     * @param string $image
     * @param string $photo
     * @param \stdClass $markup
     * @return \Model\Cake
     */
    public function createCake($image, $photo, \stdClass $markup)
    {

        $cake = $this->createRecord(\Model\Cake::NAME);
        $cake->setImageUrl($this->saveImage('cake_image_', $image));
        if (!empty($photo)) {
            $cake->setPhotoUrl($this->saveImage('cake_photo_', $photo));
        }

        $cake->setMarkup(json_encode($markup));

        return $cake;
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
