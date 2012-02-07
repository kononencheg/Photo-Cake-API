<?php

namespace Api;

use Api\Resources\Users;

class Acl implements \PhotoCake\Api\Acl\AclInterface
{
    /**
     * @var \Api\Resources\Users
     */
    private $users = null;

    public function __construct()
    {
        $this->users = Users::getInstance();
    }

    /**
     * @param array $list
     * @return boolean
     */
    function test($list)
    {
        if ($list !== null) {
            $role = $this->users->getCurrentRole();
            return $role !== NULL && in_array($role, $list);
        }

        return true;
    }
}
