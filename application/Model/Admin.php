<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

class Admin extends User
{
    /**
     * @var array
     */
    protected $data = array(
        'role' => User::ROLE_ADMIN,
    );
}
