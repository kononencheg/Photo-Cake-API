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
    const CASH = 0;

    /**
     * @const
     * @var int
     */
    const OK = 1;

    /**
     * @const
     * @var int
     */
    const VK = 2;

    /**
     * @const
     * @var int
     */
    const RBK = 3;

    /**
     * @var array
     */
    protected $fields = array(
        'payment_type' => 'int',

        'decoration_price' => 'float',
        'delivery_price' => 'float',
        'recipe_price' => 'float',
        'total_price' => 'float',
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
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->set('total_price', $totalPrice);
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->get('total_price');
    }

    /**
     * @param int $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->set('payment_type', $paymentType);
    }

    /**
     * @return int
     */
    public function getPaymentType()
    {
        return $this->get('payment_type');
    }
}
