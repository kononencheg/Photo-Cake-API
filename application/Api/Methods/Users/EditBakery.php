<?php

namespace Api\Methods\Users;

use Api\Resources\Users;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class EditBakery extends \PhotoCake\Api\Method\Method
{
    protected function extendArguments()
    {
        return array(
            'id' => array( Filter::STRING, array( null => 'Идентификатор кондитерской не задан' ) ),
            'dimension_ids' => array( Filter::ARR ),
        );
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $users = Users::getInstance();

        $bakery = $users->getById($this->getParam('id'));
        if ($bakery !== null) {

            $dimensionIds = $this->getParam('dimension_ids');
            if ($dimensionIds !== null) {
                $bakery->setAvailableDimensionIds($dimensionIds);
            }

            $users->saveUser($bakery);

            $result = $bakery->jsonSerialize();
        } else {
            $this->response
                 ->addError('Кондитерская с идентификатором "' . $this->getParam('id') . '" не найдена.', 100);
        }

        return $result;
    }
}

