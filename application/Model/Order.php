<?php

namespace Model;

class Order extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'order';


    /**
     * @const
     * @var int
     */
    const ORDER_NEW = 0;

    /**
     * @const
     * @var int
     */
    const ORDER_SUBMIT = 1;

    /**
     * @const
     * @var int
     */
    const ORDER_APPROVE = 2;


    /**
     * @const
     * @var int
     */
    const DELIVERY_NEW = 0;

    /**
     * @const
     * @var int
     */
    const DELIVERY_PROCESS = 1;

    /**
     * @const
     * @var int
     */
    const DELIVERY_COMPLETE = 2;

    /**
     * @const
     * @var int
     */
    const PAYMENT_NEW = 0;

    /**
     * @const
     * @var int
     */
    const PAYMENT_PAID = 1;

    /**
     * @var string
     */
    protected $collection = 'orders';

    /**
     * @var array
     */
    protected $options = array(
        'status' => 'int',
        'payment_status' => 'int',
        'delivery_status' => 'int',

        'bakery' => Bakery::NAME,
        'recipe' => Recipe::NAME,
        'cake' => Cake::NAME,

        'payment'  => Payment::NAME,

        'client' => Client::NAME,
        'delivery' => Delivery::NAME,
    );

    /**
     * @param Bakery $bakeryId
     */
    public function setBakery(Bakery $bakeryId)
    {
        $this->set('bakery', $bakeryId);
    }

    /**
     * @return Bakery
     */
    public function getBakeryId()
    {
        return $this->get('bakery');
    }

    /**
     * @param Cake $cake
     */
    public function setCake(Cake $cake)
    {
        $this->set('cake', $cake);
    }

    /**
     * @return Cake
     */
    public function getCake()
    {
        return $this->get('cake');
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->set('client', $client);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->get('client');
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->set('status', $status);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * @param int $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->set('payment_status', $paymentStatus);
    }

    /**
     * @return int
     */
    public function getPaymentStatus()
    {
        return $this->get('payment_status');
    }

    /**
     * @param int $deliveryStatus
     */
    public function setDeliveryStatus($deliveryStatus)
    {
        $this->set('delivery_status', $deliveryStatus);
    }

    /**
     * @return int
     */
    public function getDeliveryStatus()
    {
        return $this->get('delivery_status');
    }

    /**
     * @param Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->set('recipe', $recipe);
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->get('recipe');
    }

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->set('payment', $payment);
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->get('payment');
    }

    /**
     * @param Delivery $delivery
     */
    public function setDelivery(Delivery $delivery)
    {
        $this->set('delivery', $delivery);
    }

    /**
     * @return Delivery
     */
    public function getDelivery()
    {
        return $this->get('delivery');
    }
}
