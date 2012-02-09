<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

class Bakery extends User
{
    /**
     * @const
     * @var string
     */
    const NAME = 'bakery';

    /**
     * @var array
     */
    protected $data = array(
        'role' => User::ROLE_BAKERY,
    );

    /**
     * @param array $fields
     * @return array
     */
    protected function extendFields(array $fields)
    {
        return array_merge($fields, array(
            'city' => '\Model\City',
            'delivery_price' => 'float'
        ));
    }

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('delivery_price', '_ref'),
    );

    /**
     * @param \Model\City $city
     */
    public function setCity(\Model\City $city)
    {
        $this->set('city', $city);
    }

    /**
     * @return \Model\City
     */
    public function getCity()
    {
        return $this->get('city');
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
}
