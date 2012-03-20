<?php

namespace Api\Methods\Decorations;

use Api\Resources\Decorations;

use Model\User;
use Model\Dimension;

use PhotoCake\App\Config;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN );

    /**
     * @var array
     */
    protected $arguments = array(
        'name'  => array( Filter::STRING,  array( null => 'Имя не задано.' ) ),
        'image' => array( Filter::FILE,    array( null => 'Ошибка картинки.' ) ),
        'group' => array( Filter::INTEGER, array( null => 'Ошибка группы.' ) ),

        'is_autorotate' => array( Filter::BOOLEAN ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        var_dump($this->getParam('is_autorotate'));

        $result = null;

        $imageInfo = $this->getParam('image');
        if ($imageInfo['error'] === UPLOAD_ERR_OK) {

            $imageName = uniqid('deco_image_') . '.jpg';
            $fileName = Config::get('files.folder') . $imageName;

            if (move_uploaded_file($imageInfo['tmp_name'], $fileName)) {

                $decorations = Decorations::getInstance();

                $decoration = $decorations->createDecoration(
                    $this->getParam('name'),
                    $this->getParam('group'),
                    Config::get('files.url') . $imageName,
                    $this->getParam('is_autorotate')
                );

                $decorations->saveDecoration($decoration);

                $result = $decoration->jsonSerialize();

            } else {
                $this->response->addParamError('image', 'Ошибка обработки файла');
            }

        } else {
            $this->response->addParamError('image', 'Ошибка загрузки файла');
        }

        return $result;
    }
}
