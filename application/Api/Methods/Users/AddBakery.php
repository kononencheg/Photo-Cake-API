<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Api\Resources\Cities;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class AddBakery extends AddAdmin
{
    protected function extendArguments()
    {
        return array(
            'city_id' => array( Filter::STRING,  array( null => 'Город не задан.' ) ),
            'delivery_price' => array( Filter::FLOAT, array( null => 'Цена доставки не задана.' ) ),
        );
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        $city = Cities::getInstance()->getById($this->getParam('city_id'));
        if ($city !== null) {
            $user = Users::getInstance()->createBakery(
                $this->getParam('name'),
                $this->getParam('email'),
                $this->getParam('password'),
                $this->getParam('delivery_price')
            );

            $user->setCity($city);

            return $user;
        } else {
            $this->response->addParamError('city_id', 'Город не найден.');
        }

        return null;
    }
}

