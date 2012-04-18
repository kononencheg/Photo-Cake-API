<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Api\Resources\Cities;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class AddPartner extends AddAdmin
{
    protected function extendArguments()
    {
        return array(
            'url' => array( Filter::URL,  array( null => 'URL не задан.', false => 'URL имеет не верный формат.' ) )
        );
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        $user = Users::getInstance()->createPartner(
            $this->getParam('name'),
            $this->getParam('email'),
            $this->getParam('password'),
            $this->getParam('url')
        );


        return $user;
    }
}

