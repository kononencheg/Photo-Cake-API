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
        'data' => array( Filter::BASE64, 'data' => array( null => 'Ошибка данных.' ) ),
        'type' => array( Filter::STRING, 'data' => array( null => 'Тип данных не задан.' ) ),
        'file_name' => array( Filter::STRING ),
        'is_downloading' => array( Filter::BOOLEAN ),
    );

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

