<?php

namespace Api\Methods\Utils;

use \PhotoCake\Api\Arguments\Filter;
use \PhotoCake\Http\Response\Format\RawFormat;

class Base64Echo extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'data' => Filter::BASE64,
        'type' => Filter::STRING,
        'file_name' => Filter::STRING,
        'is_downloading' => Filter::BOOLEAN,
    );

    protected function filter()
    {
        $this->applyFilter(array(
            'data' => array( null => 'Ошибка данных' ),
            'type' => array( null => 'Тип данных не задан.' ),
        ));
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $format = new RawFormat();
        $format->setMimeType($this->getParam('type'));

        $this->response->setFormat($format);

        if ($this->getParam('is_downloading')) {
            $this->response->setHeader(
                'Content-Disposition',
                'attachment; filename=' . $this->getParam('file_name')
            );

            $this->response->setHeader(
                'Cache-Control',
                'must-revalidate, post-check=0, pre-check=0'
            );
        }

        return $this->getParam('data');
    }
}

