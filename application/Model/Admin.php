<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

class Admin extends User
{
    /**
     * @const
     * @var string
     */
    const NAME = 'admin';

    /**
     * @var array
     */
    protected $data = array(
        'role' => User::ROLE_ADMIN,
    );
}
