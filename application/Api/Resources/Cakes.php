<?php

namespace Api\Resources;

use PhotoCake\App\Config;

class Cakes extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param string $imageUrl
     * @param string $photoUrl
     * @param string $markup
     * @return \Model\Cake
     */
    public function initCake($image, $photo, \stdClass $markup)
    {
        $collection = $this->getCollection('cakes');

        $cake = $collection->createRecord();
        $cake->image_url = $this->saveImage('cake_image_', $image);
        $cake->markup = json_encode($markup);
        $cake->weight = $markup->dimensions->mass;

        var_dump($photo);

        if ($photo !== NULL) {
            $cake->photo_url = $this->saveImage('cake_photo_', $photo);
        }

        return $cake;
    }

    private function saveImage($prefix, $data) {
        $id = uniqid($prefix);
        $fileName = $id . '.jpg';

        if (file_put_contents(Config::get('files.folder') . $fileName, $data)) {
            return Config::get('files.url') . $fileName;
        }

        return NULL;
    }
}
