<?php

namespace Api\Methods\Users;

use Api\Resources\Users;
use Model\User;

use PhotoCake\Api\Arguments\Filter;

class GetBakeries extends \PhotoCake\Api\Method\Method
{
    protected $arguments = array(
        'id' => array( Filter::STRING ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = array();

        $id = $this->getParam('id');
        if ($id !== null) {
            $bakery = Users::getInstance()->getById($id);
            $result = $bakery->jsonSerialize();
        } else {
            $list = Users::getInstance()->getBakeries();
            foreach ($list as $record) {
                array_push($result, $record->jsonSerialize());
            }
        }


        return $result;
    }
}

