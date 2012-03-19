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
        'dimension_id' => array( Filter::STRING, array( null => 'Не задан идентификатор размера.' ) ),
        'markup' => array( Filter::JSON,   array( null => 'Ошибка орбатортки разметки.' ) ),
        'image'  => array( Filter::BASE64, array( null => 'Ошибка орбатортки изображения.' ) ),
        'photo'  => array( Filter::BASE64 ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $dimension = Dimensions::getInstance()->getById
                                        ($this->getParam('dimension_id'));

        if ($dimension !== null) {
            $cakes = Cakes::getInstance();

            $cake = $cakes->createCake(
                $this->getParam('image'),
                $this->getParam('photo'),
                $this->getParam('markup')
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
