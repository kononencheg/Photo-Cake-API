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
        $user = $users->getByEmail($this->getParam('email'));

        if ($user !== null) {
            if ($users->testPassword($user, $this->getParam('password'))) {
                return $users->signIn($user)->jsonSerialize();
            } else {
                $this->response->addError(
                	'Пользователь таким почтовым ящиком не зарегистрирован. ' .
                	'Либо пароль не верный!', 
            	100);
            }
        } else {
            $this->response->addError(
            	'Пользователь таким почтовым ящиком не зарегистрирован. ' .
            	'Либо пароль не верный!', 
        	100);
        }

        return null;
    }
}

