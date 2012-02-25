<?php

namespace Api\Methods\Recipes;

use Api\Resources\Recipes;
use Api\Resources\Dimensions;

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

        $recipesList = Recipes::getInstance()->getBakeryRecipes
                                            ($this->getParam('bakery_id'));

        foreach ($recipesList as $recipe) {
            array_push($result, $recipe->jsonSerialize());
        }

        return $result;
    }
}
