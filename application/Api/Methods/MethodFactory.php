<?php

namespace Api\Methods;

class MethodFactory implements \PhotoCake\Api\Method\MethodFactoryInterface
{
    /**
     * @param $name
     * @return \PhotoCake\Api\Method\Method
     */
    public function create($name)
    {
        switch ($name) {

            // Config

            case 'config.get': return new Config\Get();

            // Cities

            case 'cities.add': return new Cities\Add();
            case 'cities.get': return new Cities\Get();
            case 'cities.getCurrent': return new Cities\GetCurrent();

            // Dimensions

            case 'dimensions.add': return new Dimensions\Add();
            case 'dimensions.get': return new Dimensions\Get();
            case 'dimensions.remove': return new Dimensions\Remove();

            // Decorations

            case 'decorations.add': return new Decorations\Add();
            case 'decorations.get': return new Decorations\Get();
            case 'decorations.remove': return new Decorations\Remove();

            // Users

            case 'users.addAdmin': return new Users\AddAdmin();
            case 'users.addBakery': return new Users\AddBakery();

            case 'users.signIn': return new Users\SignIn();
            case 'users.signOut': return new Users\SignOut();

            case 'users.getCurrent': return new Users\GetCurrent();
            case 'users.getBakeries': return new Users\GetBakeries();

            case 'users.editBakery': return new Users\EditBakery();

            // Cakes

            case 'cakes.add': return new Cakes\Add();
            case 'cakes.getPromoted': return new Cakes\GetPromoted();

            // Orders

            case 'orders.add': return new Orders\Add();
            case 'orders.get': return new Orders\Get();
            case 'orders.edit': return new Orders\Edit();

            // Recipes

            case 'recipes.add': return new Recipes\Add();
            case 'recipes.get': return new Recipes\Get();
            case 'recipes.edit': return new Recipes\Edit();
            case 'recipes.remove': return new Recipes\Remove();

            // Others

            case 'social.vk.uploadImage': return new Social\Vk\UploadImage();
            case 'social.ok.uploadImage': return new Social\Ok\UploadImage();

            case 'utils.base64Echo': return new Utils\Base64Echo();

            default: return null;
        }
    }

}