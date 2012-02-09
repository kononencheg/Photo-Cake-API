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
        'email'    => array( Filter::EMAIL,  array( null => 'Email не задан.', false => 'Email имеет не верный формат!' ) ),
        'password' => array( Filter::STRING, array( null => 'Пароль не задан.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $users = Users::getInstance();
        $user = $users->getByEmail($this->getParam('email'));

        if ($user !== null &&
            $users->testPassword($user, $this->getParam('password'))) {

            return $users->signIn($user)->jsonSerialize();
        } else {
            $this->response->addError(
            	'Пользователь таким почтовым ящиком не зарегистрирован. ' .
            	'Либо пароль не верный!', 
        	100);
        }

        return null;
    }
}

