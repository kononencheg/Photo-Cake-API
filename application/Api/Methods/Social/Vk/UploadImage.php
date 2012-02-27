<?php

namespace Api\Methods\Social\Vk;

use PhotoCake\Api\Arguments\Filter;
use PhotoCake\App\Config;

class UploadImage extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'image' => array( Filter::BASE64, array( null => 'Ошибка данных изображения' ) ),
        'upload_url' => array( Filter::URL, array( null => 'Url сервера загрузки не задан.', false => 'Url сервера загрузки имеет неверный формат.' ))
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $fileName = Config::get('files.folder') .
                        uniqid('temp_cake_image_') . '.jpg';

        file_put_contents($fileName, $this->getParam('image'), FILE_BINARY);

        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $this->getParam('upload_url'));
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, array(
            "photo" => '@' . $fileName,
        ));

        $result = curl_exec($request);

        curl_close($request);
        unlink($fileName);

        return json_decode($result);
    }
}

