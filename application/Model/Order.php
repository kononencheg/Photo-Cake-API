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
    const ORDER_APPROVED = 1;

    /**
     * @const
     * @var int
     */
    const ORDER_DECLINED = 2;

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

        'creation_time' => 'int',

        'bakery' => Bakery::NAME,
        'recipe' => Recipe::NAME,
        'cake' => Cake::NAME,

        'payment'  => Payment::NAME,
        'client' => Client::NAME,
        'delivery' => Delivery::NAME,

        'partner' => Partner::NAME,
    );

    /**
     * @param \Model\Bakery $bakery
     */
    public function setBakery(Bakery $bakery)
    {
        $this->set('bakery', $bakery);
    }

    /**
     * @return \Model\Bakery
     */
    public function getBakery()
    {
        return $this->get('bakery');
    }

    /**
     * @param \Model\Cake $cake
     */
    public function setCake(Cake $cake)
    {
        $this->set('cake', $cake);
    }

    /**
     * @return \Model\Cake
     */
    public function getCake()
    {
        return $this->get('cake');
    }

    /**
     * @param \Model\Client $client
     */
    public function setClient(Client $client)
    {
        $this->set('client', $client);
    }

    /**
     * @return \Model\Client
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
     * @param \Model\Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->set('recipe', $recipe);
    }

    /**
     * @return \Model\Recipe
     */
    public function getRecipe()
    {
        return $this->get('recipe');
    }

    /**
     * @param \Model\Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->set('payment', $payment);
    }

    /**
     * @return \Model\Payment
     */
    public function getPayment()
    {
        return $this->get('payment');
    }

    /**
     * @param \Model\Delivery $delivery
     */
    public function setDelivery(Delivery $delivery)
    {
        $this->set('delivery', $delivery);
    }

    /**
     * @return \Model\Delivery
     */
    public function getDelivery()
    {
        return $this->get('delivery');
    }

    /**
     * @param int $time
     */
    public function setCreationTime($time)
    {
        $this->set('creation_time', $time);
    }

    /**
     * @return int
     */
    public function getCreationTime()
    {
        return $this->get('creation_time');
    }

    /**
     * @param \Model\Partner
     */
    public function setPartner(Partner $partner)
    {
        $this->set('partner', $partner);
    }

    /**
     * @return \Model\Partner
     */
    public function getPartner()
    {
        return $this->get('partner');
    }

}
