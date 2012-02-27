<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class AddAdmin extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN );

    /**
     * @var array
     */
    protected $arguments = array(
        'name'     => array( Filter::STRING, array( null => 'Имя не задано.' ) ),
        'email'    => array( Filter::EMAIL,  array( null => 'Email не задан.', false => 'Email имеет не верный формат!' ) ),
        'password' => array( Filter::STRING, array( null => 'Пароль не задан.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $users = Users::getInstance();
        $email = $this->getParam('email');

        $user = $users->getByEmail($email);
        if ($user === null) {
            $password = $this->getParam('password');

            if (strlen($password) >= 6) {
                $user = $this->createUser();

                if ($user !== null) {
                    $users->saveUser($user);
                    return $user->jsonSerialize();
                }
            } else {
                $this->response->addParamError
                    ('password', 'Пароль слишком короткий.');
            }

        } else {
            $this->response->addParamError('email',
                    'Пользователь с почтовым ящиком ' . $this->getParam('email') .
                            ' уже зарегистрирован.');
        }

        return null;
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        return Users::getInstance()->createAdmin(
            $this->getParam('name'),
            $this->getParam('email'),
            $this->getParam('password')
        );
    }
}

