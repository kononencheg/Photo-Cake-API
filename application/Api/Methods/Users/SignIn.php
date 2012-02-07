<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use PhotoCake\Api\Arguments\Filter;

class SignIn extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'email' => Filter::STRING,
        'password' => Filter::STRING,
    );

    protected function filter()
    {
        $this->applyFilter(array(
            'email' => array( null => 'Email не задан.' ),
            'password' => array( null => 'Пароль не задан.' ),
        ));
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $users = Users::getInstance();
        $user = $users->getByEmail($this->param('email'));

        if ($user !== null) {
            if ($users->testPassword($user, $this->param('password'))) {
                return $users->signIn($user);
            } else {
                $this->response->addParamError('password', 'Неверный пароль.');
            }
        } else {
            $this->response->addParamError('email',
                    'Пользователь с почтовым ящиком ' . $this->param('email') .
                            ' не зарегистрирован.');
        }

        return null;
    }
}

