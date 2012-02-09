<?php

namespace Api\Methods\Recipes;

use Api\Resources\Recipes;

use \PhotoCake\Api\Arguments\Filter;

class Get extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Идентификатор кондитерской не задан.' ) )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $list = Recipes::getInstance()->getBakeryRecipes
                                            ($this->getParam('bakery_id'));

        foreach ($list as $record) {
            array_push($result, $record->jsonSerialize());
        }

        return $result;
    }
}
