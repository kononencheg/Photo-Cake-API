<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

class User extends MongoRecord
{
    /**
     * @const
     * @var int
     */
    const ADMIN = 0;

    /**
     * @const
     * @var int
     */
    const BAKERY = 1;

    /**
     * @var string
     */
    protected $collection = 'users';

    /**
     * @var array
     */
    protected $fields = array(
        'email' => 'string',
        'password' => array(
            'type' => 'string',
            'visibility' => MongoRecord::VISIBILITY_HIDDEN
        ),

        'role' => 'int'
    );

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
    public function getPassword() {
        return $this->get('password');
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->set('password', $password);
    }

    /**
     * @return int
     */
    public function getRole() {
        return $this->get('role');
    }

    /**
     * @param string $role
     */
    public function setRole($role) {
        $this->set('role', $role);
    }

}
