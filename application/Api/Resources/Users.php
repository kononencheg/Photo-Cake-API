<?php

namespace Api\Resources;

class Users extends \Api\Resources\Resource
{
    /**
     * @param string $email
     * @param string $password
     * @return \Model\Admin
     */
    public function createAdmin($email, $password)
    {
        $user = new \Model\Admin();
        $user->setPassword($this->saltPassword($password));
        $user->setEmail($email);

        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @return \Model\Bakery
     */
    public function createBakery($email, $password)
    {
        $user = new \Model\Bakery();
        $user->setPassword($this->saltPassword($password));
        $user->setEmail($email);

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
     * @return \Model\User
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
