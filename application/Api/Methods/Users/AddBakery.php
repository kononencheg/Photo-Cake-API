<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class AddBakery extends AddAdmin
{
    /**
     * @return User
     */
    protected function createUser()
    {
        return Users::getInstance()->createBakery
                    ($this->getParam('email'), $this->getParam('password'));
    }
}

