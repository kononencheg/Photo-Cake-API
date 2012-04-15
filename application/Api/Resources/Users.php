<?php

namespace Api\Resources;

use Model\User;

class Users extends \Api\Resources\Resource
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return \Model\Admin
     */
    public function createAdmin($name, $email, $password)
    {
        $user = $this->createRecord(\Model\Admin::NAME);
        $user->setPassword($this->saltPassword($password));
        $user->setEmail($email);
        $user->setName($name);

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @param float $deliveryPrice
     * @return \Model\Bakery
     */
    public function createBakery($name, $email, $password, $deliveryPrice)
    {
        $user = $this->createRecord(\Model\Bakery::NAME);
        $user->setPassword($this->saltPassword($password));
        $user->setEmail($email);
        $user->setName($name);
        $user->setDeliveryPrice($deliveryPrice);

        return $user;
    }

    /**
     * @param \Model\User $user
     */
    public function saveUser(\Model\User $user)
    {
        $this->getCollection('users')->update($user);
    }

    /**
     * @param string $id
     * @return \Model\User|\Model\Bakery
     */
    public function getById($id)
    {
        return $this->getCollection('users')->fetch($id);
    }

    /**
     * @param string $email
     * @return \Model\User
     */
    public function getByEmail($email)
    {
        return $this->getCollection('users')
                    ->fetchOne(array( 'email' => $email ));
    }

    /**
     * @param \Model\User $user
     * @param string $password
     * @return boolean
     */
    public function testPassword(\Model\User $user, $password)
    {
        return $user->getPassword() === $this->saltPassword($password);
    }

    /**
     * @param \Model\User $user
     * @param string $password
     */
    public function changePassword(\Model\User $user, $password)
    {
        $user->setPassword($this->saltPassword($password));
    }

    /**
     * @param \Model\User $user
     * @return \Model\User
     */
    public function signIn(\Model\User $user)
    {
        $this->session->set('role', $user->getRole());
        $this->session->set('id', $user->getId());

        return $this->getCurrentUser();
    }

    /**
     * @return bool
     */
    public function signOut()
    {
        $this->session->remove('role');
        $this->session->remove('id');

        return true;
    }

    public function getBakeries()
    {
        return $this->getCollection('users')->fetchAll(array(
            'role' => User::ROLE_BAKERY
        ));
    }

    /**
     * @return \Model\User
     */
    public function getCurrentUser()
    {
        $id = $this->session->get('id');

        if ($id !== null) {
            return $this->getCollection('users')->fetch($id);
        }

        return null;
    }

    /**
     * @return int
     */
    public function getCurrentRole()
    {
        return $this->session->get('role');
    }

    /**
     * @return string
     */
    public function getCurrentUserId()
    {
        return $this->session->get('id');
    }

    /**
     * @param string $password
     * @return string
     */
    private function saltPassword($password)
    {
        return md5($password . '-and-salty-cake');
    }

    /**
     * @static
     * @var \Api\Resources\Users
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Users
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Users();
        }

        return self::$instance;
    }
}
