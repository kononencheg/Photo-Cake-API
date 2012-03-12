<?php

namespace Api\Methods\Recipes;

use Model\Recipe;

use Api\Resources\Recipes;
use Api\Resources\Dimensions;

use \PhotoCake\Api\Arguments\Filter;

class Edit extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'id' => array( Filter::STRING, array( null => 'Не задан идентификатор рецепта.' ) ),
        'dimension_prices' => array( Filter::ARR )
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $recipes = Recipes::getInstance();
        $dimensions = Dimensions::getInstance();

        $recipe = $recipes->getById($this->getParam('id'));
        if ($recipe !== null) {

            $dimensionPrices = $this->getParam('dimension_prices');
            if ($dimensionPrices !== null) {
                foreach($dimensionPrices as $weight => $price) {
                    $recipe->addDimensionPrice
                        ($dimensions->createDimensionPrice($weight, $price));
                }
            }

            $recipes->saveRecipe($recipe);

            $result = $recipe->jsonSerialize();
        } else {
            $this->response
                 ->addError('Рецепт с идентификатором "' . $this->getParam('id') . '" не найден.', 100);
        }

        return $result;
    }


}
