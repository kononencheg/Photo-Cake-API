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

            case 'users.add': return new Users\Add();
            case 'users.signIn': return new Users\SignIn();
            case 'users.signOut': return new Users\SignOut();
            case 'users.getCurrent': return new Users\GetCurrent();

            case 'cities.getList': return new Cities\GetList();

            case 'orders.submit': return new Orders\Submit();

            case 'bakeries.getList': return new Bakeries\GetList();

            case 'recipes.getList': return new Recipes\GetList();

            case 'social.vk.uploadImage': return new Social\Vk\UploadImage();
            case 'social.ok.uploadImage': return new Social\Ok\UploadImage();

            case 'utils.base64Echo': return new Utils\Base64Echo();

            default: return null;
        }
    }

}