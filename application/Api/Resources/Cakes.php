<?php

namespace Api\Resources;

use PhotoCake\App\Config;

class Cakes extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param string $image
     * @param string $photo
     * @param \stdClass $markup
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function initCake($image, $photo, \stdClass $markup)
    {
        $collection = $this->getCollection('cakes');

        $cake = $collection->createRecord();
        $cake->set('image_url', $this->saveImage('cake_image_', $image));
        $cake->set('markup', json_encode($markup));
        $cake->set('weight', $markup->dimensions->mass);

        if (!empty($photo)) {
            $cake->set('photo_url', $this->saveImage('cake_photo_', $photo));
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
