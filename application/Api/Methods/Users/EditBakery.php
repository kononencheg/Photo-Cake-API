<?php

namespace Api\Methods\Users;

use Api\Resources\Users;
use Api\Resources\Decorations;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class EditBakery extends \PhotoCake\Api\Method\Method
{
    protected function extendArguments()
    {
        return array(
            'id' => array( Filter::STRING, array( null => 'Идентификатор кондитерской не задан' ) ),
            'name' => array( Filter::STRING, array( null => 'Имя не задано' ) ),
            'email' => array( Filter::EMAIL, array( null => 'Email не задан.', false => 'Email имеет не верный формат!') ),

            'contact_name' => array( Filter::STRING ),
            'contact_phone' => array( Filter::PHONE ),
            'contact_email' => array( Filter::EMAIL ),

            'phone' => array( Filter::PHONE, array( null => 'Телефон не задан.' ) ),
            'address' => array( Filter::STRING, array( null => 'Адрес самовывоза не задан.' ) ),
            'delivery_price' => array( Filter::FLOAT, array( null => 'Цена доставки не задана.' ) ),
            'cash_extra_charge' => array( Filter::FLOAT, array( null => 'Наценка за наличную оплату не задана.' ) ),
        );
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $users = Users::getInstance();

        $bakery = $users->getById($this->getParam('id'));
        if ($bakery !== null) {

            $bakery->setName($this->getParam('name'));
            $bakery->setEmail($this->getParam('email'));

            $bakery->setContactName($this->getParam('contact_name'));
            $bakery->setContactPhone($this->getParam('contact_name'));
            $bakery->setContactEmail($this->getParam('contact_email'));

            $bakery->setPhone($this->getParam('phone'));
            $bakery->setAddress($this->getParam('address'));
            $bakery->setDeliveryPrice($this->getParam('delivery_price'));
            $bakery->setCashExtraCharge($this->getParam('cash_extra_charge'));

            $users->saveUser($bakery);

            $result = $bakery->jsonSerialize();
        } else {
            $this->response
                 ->addError('Кондитерская с идентификатором "' . $this->getParam('id') . '" не найдена.', 100);
        }

        return $result;
    }
}

