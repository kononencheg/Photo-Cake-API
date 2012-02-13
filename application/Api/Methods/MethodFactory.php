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

            // Users

            case 'users.addAdmin': return new Users\AddAdmin();
            case 'users.addBakery': return new Users\AddBakery();

            case 'users.signIn': return new Users\SignIn();
            case 'users.signOut': return new Users\SignOut();

            case 'users.getCurrent': return new Users\GetCurrent();
            case 'users.getBakeries': return new Users\GetBakeries();

            // Orders

            case 'orders.add': return new Orders\Submit();

            case 'orders.submit': return new Orders\Submit();

            case 'orders.get': return new Orders\Submit();

            // Recipes

            case 'recipes.add': return new Recipes\Add();

            case 'recipes.get': return new Recipes\Get();

            case 'recipes.remove': return new Recipes\Remove();

            // Others

            case 'social.vk.uploadImage': return new Social\Vk\UploadImage();
            case 'social.ok.uploadImage': return new Social\Ok\UploadImage();

            case 'utils.base64Echo': return new Utils\Base64Echo();

            default: return null;
        }
    }

}