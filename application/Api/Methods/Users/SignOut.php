<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use PhotoCake\Api\Arguments\Filter;

class SignOut extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        return Users::getInstance()->signOut();
    }
}

