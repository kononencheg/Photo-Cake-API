<?php

namespace Api\Methods\Recipes;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use PhotoCake\Api\Arguments\Filter;

use PhotoCake\App\Config;

class Remove extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'recipe_id' => array( Filter::STRING, array( null => 'Параметр не задан.' ) )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        Recipes::getInstance()->removeById($this->getParam('recipe_id'));

        return true;
    }
}
