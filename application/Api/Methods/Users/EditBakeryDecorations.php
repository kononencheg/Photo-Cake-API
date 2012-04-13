<?php

namespace Api\Methods\Users;

use Api\Resources\Users;
use Api\Resources\Decorations;

use Model\User;

use PhotoCake\Api\Arguments\Filter;

class EditBakeryDecorations extends \PhotoCake\Api\Method\Method
{
    protected function extendArguments()
    {
        return array(
            'id' => array( Filter::STRING, array( null => 'Идентификатор кондитерской не задан' ) ),
            'decoration_prices' => array( Filter::ARR ),
        );
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $result = null;

        $users = Users::getInstance();
        $decorations = Decorations::getInstance();

        $bakery = $users->getById($this->getParam('id'));
        if ($bakery !== null) {

            $decorationPrices = $this->getParam('decoration_prices');


            if ($decorationPrices !== null) {
                $prices = $bakery->getDecorationPrices();

                if (!empty($prices)) {
                    foreach ($prices as $decorationId => $decorationPrice) {
                        if (isset($decorationPrices[$decorationId])) {
                            $decorationPrice->setPrice($decorationPrices[$decorationId]);
                            unset($decorationPrices[$decorationId]);
                        } else {
                            $bakery->removeDecorationPrice($decorationPrice);
                        }
                    }
                }

                foreach ($decorationPrices as $decorationId => $price) {
                    $bakery->addDecorationPrice($decorations->createDecorationPrice($decorationId, $price));
                }
            } else {
                $bakery->removeDecorationPrices();
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

