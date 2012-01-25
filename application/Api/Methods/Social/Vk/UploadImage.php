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
        'image' => Filter::BASE64,
        'upload_url' => Filter::URL,
    );

    protected function filter()
    {
        $this->applyFilter(array(
            'image' => array( NULL => 'Ошибка данных изображения' ),
            'upload_url' => array(
                NULL => 'Url сервера загрузки не задан.',
                false => 'Url сервера загрузки имеет неверный формат.'
            ),
        ));
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $fileName = Config::get('files.folder') .
                        uniqid('temp_cake_image_') . '.jpg';

        file_put_contents($fileName, $this->param('image'), FILE_BINARY);

        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $this->param('upload_url'));
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

