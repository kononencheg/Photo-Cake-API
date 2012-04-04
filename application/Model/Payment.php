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
    protected $options = array(
        'payment_method' => 'int',
        'transaction_id' => 'string',

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
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->get('recipe_price') +
                $this->get('delivery_price') +
                $this->get('decoration_price');
    }

    /**
     * @param int $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->set('payment_method', $paymentMethod);
    }

    /**
     * @return int
     */
    public function getPaymentMethod()
    {
        return $this->get('payment_method');
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->set('transaction_id', $transactionId);
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->get('transaction_id');
    }
}
