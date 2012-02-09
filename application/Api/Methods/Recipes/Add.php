<?php

namespace Api\Methods\Recipes;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Ошибка выбора кондитерской.' ) ),

        'recipe_name' => array( Filter::STRING, array( null => 'Ошибка имени рецепта.' ) ),
        'recipe_desc' => array( Filter::STRING, array( null => 'Ошибка описания рецепта.' ) ),
        'recipe_image_url' => array( Filter::STRING, array( null => 'Ошибка картинки рецепта.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $recipes = Recipes::getInstance();

        $recipe = $recipes->createRecipe(
            $this->getParam('bakery_id'),
            $this->getParam('recipe_name'),
            $this->getParam('recipe_desc'),
            $this->getParam('recipe_image_url')
        );

        $recipes->saveRecipe($recipe);

        return $recipe->jsonSerialize();
    }
}
