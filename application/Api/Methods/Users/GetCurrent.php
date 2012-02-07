<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

class GetCurrent extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $user = Users::getInstance()->getCurrentUser();
        if ($user !== null) {
            return $user->jsonSerialize();
        }

        return null;
    }
}

