<?php

namespace Api\Methods\Users;

use Api\Resources\Users;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class ChangePassword extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $accessList = array( User::ROLE_ADMIN, User::ROLE_BAKERY );

    /**
     * @var array
     */
    protected $arguments = array(
        'id' => array( Filter::STRING, array( null => 'Идентификатор пользователя не задан.' ) ),
        'old_password' => array( Filter::STRING, array( null => 'Старый пароль не задан.' ) ),
        'new_password' => array( Filter::STRING, array( null => 'Новый пароль не задан.' ) ),
        'confirm_password' => array( Filter::STRING,  array( null => 'Подтверждение пароля должно быть введено.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $newPassword = $this->getParam('new_password');

        if ($this->getParam('confirm_password') === $newPassword) {
            $users = Users::getInstance();
            $user = $users->getById($this->getParam('id'));

            if ($user !== null &&
                $users->testPassword($user, $this->getParam('old_password'))) {
                $users->changePassword($user, $newPassword);
                $users->saveUser($user);
            } else {
                $this->response->addParamError('old_password', 'Пароль не верный');
            }

        } else {
            $this->response->addParamError('new_password', 'Пароли не совпадают');
            $this->response->addParamError('confirm_password', 'Пароли не совпадают');
        }

        return null;
    }

}

