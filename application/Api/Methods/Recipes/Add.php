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

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Ошибка выбора кондитерской.' ) ),

        'recipe_name' => array( Filter::STRING, array( null => 'Ошибка имени рецепта.' ) ),
        'recipe_desc' => array( Filter::STRING, array( null => 'Ошибка описания рецепта.' ) ),
        'recipe_image' => array( Filter::FILE, array( null => 'Ошибка картинки рецепта.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $imageInfo = $this->getParam('recipe_image');
        if ($imageInfo['error'] === UPLOAD_ERR_OK) {

            $imageName = uniqid('recipe_image_') . '.jpg';
            $fileName = Config::get('files.folder') . $imageName;

            if (move_uploaded_file($imageInfo['tmp_name'], $fileName)) {

                $recipes = Recipes::getInstance();

                $recipe = $recipes->createRecipe(
                    $this->getParam('bakery_id'),
                    $this->getParam('recipe_name'),
                    $this->getParam('recipe_desc'),
                    Config::get('files.url') . $imageName
                );

                $recipes->saveRecipe($recipe);

                return $recipe->jsonSerialize();

            } else {
                $this->response
                     ->addParamError('recipe_image', 'Ошибка обработки файла');
            }

        } else {
            $this->response
                 ->addParamError('recipe_image', 'Ошибка загрузки файла');
        }

        return null;
    }
}
