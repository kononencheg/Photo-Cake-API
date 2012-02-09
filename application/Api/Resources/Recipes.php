<?php

namespace Api\Resources;

use Model\Recipe;

class Recipes extends \Api\Resources\Resource
{
    /**
     * @param string $bakeryId
     * @param string $name
     * @param string $desc
     * @param string $imageUrl
     * @return \Model\Recipe
     */
    public function createRecipe($bakeryId, $name, $desc, $imageUrl)
    {
        $recipe = $this->createRecord(Recipe::NAME);
        $recipe->setBakeryId($bakeryId);
        $recipe->setName($name);
        $recipe->setDesc($desc);
        $recipe->setImageUrl($imageUrl);

        return $recipe;
    }

    /**
     * @param \Model\Recipe $recipe
     */
    public function saveRecipe(Recipe $recipe)
    {
        $this->getCollection('recipes')->update($recipe);
    }

    /**
     * @param string $id
     * @return \Model\Recipe
     */
    public function getById($id)
    {
        return $this->getCollection('recipes')->fetch($id);
    }

    /**
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getBakeryRecipes($bakeryId)
    {
        return $this->getCollection('recipes')->fetchAll(array(
            'bakery_id' => $bakeryId
        ));
    }

    /**
     * @static
     * @var \Api\Resources\Recipes
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Recipes
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Recipes();
        }

        return self::$instance;
    }
}
