<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

abstract class User extends MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'user';

    /**
     * @const
     * @var int
     */
    const ROLE_ADMIN = 0;

    /**
     * @const
     * @var int
     */
    const ROLE_BAKERY = 1;

    /**
     * @var string
     */
    protected $collection = 'users';

    /**
     * @var array
     */
    protected $fields = array(
        'name' => 'string',
        'role' => 'int',

        'email' => 'string',

        'password' => array(
            'type' => 'string',
            'visibility' => MongoRecord::VISIBILITY_HIDDEN
        ),
    );

    /**
     * @return int
     */
    public function getRole() {
        return $this->get('role');
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->get('email');
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->set('email', $email);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->get('name');
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->set('name', $name);
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->get('password');
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->set('password', $password);
    }
}
