<?php

namespace Api\Methods\Cakes;

use Api\Resources\Orders;
use Api\Resources\Dimensions;
use Api\Resources\Cakes;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'shape'        => array( Filter::STRING, array( null => 'Не задан размер торта.' ) ),
        'weight'       => array( Filter::FLOAT,  array( null => 'Не задана масса торта.' ) ),
        'markup_json'  => array( Filter::JSON,   array( null => 'Ошибка орбатортки разметки.' ) ),
        'image_base64' => array( Filter::BASE64, array( null => 'Ошибка орбатортки изображения.' ) ),
        'photo_base64' => array( Filter::BASE64 ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $dimension = Dimensions::getInstance()->getOne(
            $this->getParam('weight'),
            $this->getParam('shape')
        );

        if ($dimension !== null) {
            $cakes = Cakes::getInstance();

            $cake = $cakes->createCake(
                $this->getParam('image_base64'),
                $this->getParam('photo_base64'),
                $this->getParam('markup_json')
            );

            $cake->setDimension($dimension);

            $cakes->saveCake($cake);

            $result = $cake->jsonSerialize();
        } else {
            $this->response
                 ->addError('Соответсвующие массе размеры не найдены.', 100);
        }

        return $result;
    }
}
