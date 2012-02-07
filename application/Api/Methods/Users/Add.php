<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ADMIN );

    /**
     * @var array
     */
    protected $arguments = array(
        'email' => Filter::STRING,
        'password' => Filter::STRING,
        'role' => array( User::ADMIN, User::BAKERY ),
    );

    protected function filter()
    {
        $this->applyFilter(array(
            'email' => array( null => 'Email не задан.' ),
            'password' => array( null => 'Пароль не задан.' ),
            'role' => array( null => 'Роль не сущствует.' ),
        ));
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $users = Users::getInstance();
        $email = $this->param('email');

        $user = $users->getByEmail($email);
        if ($user === null) {
            $password = $this->param('password');

            if (strlen($password) >= 6) {
                $user = $users->createUser
                    ($email, $password, $this->param('role'));

                var_dump($user->dbSerialize());
                var_dump($user->jsonSerialize());

            } else {
                $this->response->addParamError
                    ('password', 'Пароль слишком короткий.');
            }

        } else {
            $this->response->addParamError('email',
                    'Пользователь с почтовым ящиком ' . $this->param('email') .
                            ' уже зарегистрирован.');
        }

        return $user;
    }
}

