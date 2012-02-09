<?php

namespace Model;

class Payment extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'payment';

    /**
     * @const
     * @var int
     */
    const METHOD_NONE = -1;

    /**
     * @const
     * @var int
     */
    const METHOD_CASH = 0;

    /**
     * @const
     * @var int
     */
    const METHOD_OK = 1;

    /**
     * @const
     * @var int
     */
    const METHOD_VK = 2;

    /**
     * @const
     * @var int
     */
    const METHOD_RBK = 3;

    /**
     * @var array
     */
    protected $fields = array(
        'payment_method' => 'int',

        'decoration_price' => 'float',
        'delivery_price' => 'float',
        'recipe_price' => 'float',
    );

    /**
     * @param float $decorationPrice
     */
    public function setDecorationPrice($decorationPrice)
    {
        $this->set('decoration_price', $decorationPrice);
    }

    /**
     * @return float
     */
    public function getDecorationPrice()
    {
        return $this->get('decoration_price');
    }

    /**
     * @param float $deliveryPrice
     */
    public function setDeliveryPrice($deliveryPrice)
    {
        $this->set('delivery_price', $deliveryPrice);
    }

    /**
     * @return float
     */
    public function getDeliveryPrice()
    {
        return $this->get('delivery_price');
    }

    /**
     * @param float $recipePrice
     */
    public function setRecipePrice($recipePrice)
    {
        $this->set('recipe_price', $recipePrice);
    }

    /**
     * @return float
     */
    public function getRecipePrice()
    {
        return $this->get('recipe_price');
    }

    /**
     * @param int $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->set('payment_type', $paymentMethod);
    }

    /**
     * @return int
     */
    public function getPaymentMethod()
    {
        return $this->get('payment_type');
    }
}
