<?php

namespace Api\Methods\Config;

use Api\Resources\Decorations;
use PhotoCake\App\Config;

use \PhotoCake\Api\Arguments\Filter;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'app'  => array( Filter::STRING,  array( null => 'Приложение не задано.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $env = Config::getApplicationEnv();
        $app = $this->getParam('app');
        $config = null;

        switch ($app) {
            case 'admin-panel': {
                $config = Config::parseFile(INI_PATH  . '/' . $app. '.ini');
                break;
            }

            default: {
                $this->response->addParamError('application', 'Неизвестное приложение!');
            }
        }

        if (isset($config[$env])) {
            return $config[$env];
        }

        return null;
    }
}
