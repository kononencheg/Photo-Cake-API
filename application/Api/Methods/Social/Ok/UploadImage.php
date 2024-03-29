<?php

namespace Api\Methods\Social\Ok;

use PhotoCake\Api\Arguments\Filter;
use PhotoCake\App\Config;

class UploadImage extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'image' => array( Filter::BASE64, array( null => 'Ошибка данных изображения' ) ),
        'upload_url' => array( Filter::URL, array( null => 'Url сервера загрузки не задан.', false => 'Url сервера загрузки имеет неверный формат.' )),
        'album_id' => array( Filter::STRING ),
        'session_key' => array( Filter::STRING ),
        'album_id' => array( Filter::STRING ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $fileName = Config::get('files.folder') . 
        				uniqid('temp_cake_image_') . '.jpg';

        file_put_contents($fileName, $this->getParam('image'), FILE_BINARY);

        $params = array(
            'application_key' => $this->getParam('application_key'),
            'session_key' => $this->getParam('session_key'),
            'aid' => $this->getParam('album_id'),
            'method' => 'photos.upload',
            'photos' => '[{}]',
            'file' => md5_file($fileName)
        );

        $params['sig'] = $this->generateSig($params);

		$getParams = array();
        foreach ($params as $name => $value) {
        	array_push($getParams, $name . '=' . urlencode($value));
        }

        $request = curl_init();
        curl_setopt(
            $request, CURLOPT_URL, $this->getParam('upload_url') . '?' .
                join('&', $getParams)
        );

        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, array(
            'file_1' => '@' . $fileName
        ));

        $result = curl_exec($request);

        curl_close($request);
        unlink($fileName);

        return json_decode($result);
    }

    private function generateSig($params)
    {
        $plainParams = array();
        foreach ($params as $name => $value) {
            array_push($plainParams, $name . '=' . $value);
        }

        sort($plainParams);

        return md5(join('', $plainParams) . $this->getParam('secret_key'));
    }
}

