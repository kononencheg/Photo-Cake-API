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

            case 'cities.getList': return new Cities\GetList();

            case 'orders.submit': return new Orders\Submit();

            case 'bakeries.getList': return new Bakeries\GetList();

            case 'recipes.getList': return new Recipes\GetList();

            case 'social.vk.uploadImage': return new Social\Vk\UploadImage();

            case 'utils.base64Echo': return new Utils\Base64Echo();

            default: return NULL;
        }
    }

}