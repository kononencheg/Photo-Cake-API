<?php

namespace Api\Methods\Orders;

use Api\Resources\Orders;
use Api\Resources\Recipes;
use Api\Resources\Dimensions;
use Api\Resources\Users;
use Api\Resources\Cakes;
use Api\Resources\Payments;

use PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var array
     */
    protected $arguments = array(
        'bakery_id' => array( Filter::STRING, array( null => 'Ошибка выбора кондитерской.' ) ),
        'recipe_id' => array( Filter::STRING, array( null => 'Ошибка выбора рецепта.' ) ),

        'cake_shape'        => array( Filter::STRING, array( null => 'Ошибка данных торта.' ) ),
        'cake_weight'       => array( Filter::FLOAT,  array( null => 'Ошибка данных торта.' ) ),
        'cake_markup_json'  => array( Filter::JSON,   array( null => 'Ошибка данных торта.' ) ),
        'cake_image_base64' => array( Filter::BASE64, array( null => 'Ошибка данных торта.' ) ),
        'cake_photo_base64' => array( Filter::BASE64, array( null => 'Ошибка данных торта.' ) ),
    );

    /**
     * @return mixed
     */
    protected function apply()
    {
        $orders = Orders::getInstance();

        $recipe = Recipes::getInstance()->getById($this->getParam('recipe_id'));
        $bakery = Users::getInstance()->getById($this->getParam('bakery_id'));
        $cake = $this->createCake();

        if ($recipe !== null && $cake !== null && $bakery !== null) {
            $order = $orders->createOrder();

            $order->setPayment($this->createPayment($bakery, $cake, $recipe));
            $order->setBakery($bakery);
            $order->setRecipe($recipe);
            $order->setCake($cake);

            $orders->saveOrder($order);

            return $order->jsonSerialize();
        } else {
            $this->response
                 ->addError('Ошибка обработки данных заказа.', 100);
        }

        return null;
    }

    /**
     * @param \Model\Bakery $bakery
     * @param \Model\Cake $cake
     * @param \Model\Recipe $recipe
     * @return \Model\Payment
     */
    private function createPayment(\Model\Bakery $bakery, \Model\Cake $cake,
                                   \Model\Recipe $recipe)
    {
        $payments = Payments::getInstance();

        $payment = $payments->createPayment();

        $payment->setDeliveryPrice($bakery->getDeliveryPrice());
        $payment->setRecipePrice(
            $payments->getRecipePrice($recipe, $cake->getDimension())
        );

        $payment->setDecorationPrice(
            $payments->getDecorationPrice($this->getParam('cake_markup_json'))
        );

        return $payment;
    }

    /**
     * @return \Model\Cake
     */
    private function createCake()
    {
        $dimensions = Dimensions::getInstance()->getByWeight(
            $this->getParam('bakery_id'),
            $this->getParam('cake_weight'),
            $this->getParam('cake_shape')
        );

        if ($dimensions !== null) {
            $cakes = Cakes::getInstance();
            $cake = $cakes->createCake(
                $this->getParam('cake_photo_base64'),
                $this->getParam('cake_image_base64'),
                $this->getParam('cake_markup_json')
            );

            $cake->setDimension($dimensions);

            return $cake;
        }

        return null;
    }

}
