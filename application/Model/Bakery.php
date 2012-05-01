<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

use Model\DecorationPrice;

class Bakery extends Partner
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
    protected function extendOptions()
    {
        return array(
            'city' => City::NAME,
            'address' => 'string',
            'phone' => 'string',
            'contact_name' => 'string',
            'contact_phone' => 'string',
            'contact_email' => 'string',
            'delivery_price' => 'float',
            'cash_extra_charge'  => 'float',
            'decoration_prices' =>  array( 'type' => DecorationPrice::NAME,
                                           'relation' => MongoRecord::RELATION_MANY,
                                           'key_field' => 'decoration_id' ),
        );
    }

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('city', 'address', 'delivery_price', '_ref'),
    );

    /**
     * @param \Model\City $city
     */
    public function setCity(\Model\City $city){ $this->set('city', $city); }

    /**
     * @return \Model\City
     */
    public function getCity() { return $this->get('city'); }

    /**
     * @param string $address
     */
    public function setAddress($address) { $this->set('address', $address); }

    /**
     * @return string
     */
    public function getAddress() { return $this->get('address'); }

    /**
     * @param string $phone
     */
    public function setPhone($phone) { $this->set('phone', $phone); }

    /**
     * @return string
     */
    public function getPhone() { return $this->get('phone'); }

    /**
     * @param string $name
     */
    public function setContactName($name) { $this->set('contact_name', $name); }

    /**
     * @return string
     */
    public function getContactName() { return $this->get('contact_name'); }

    /**
     * @param string $phone
     */
    public function setContactPhone($phone) { $this->set('contact_phone', $phone); }

    /**
     * @return string
     */
    public function getContactPhone() { return $this->get('contact_phone'); }

    /**
     * @param string $email
     */
    public function setContactEmail($email) { $this->set('contact_email', $email); }

    /**
     * @return string
     */
    public function getContactEmail() { return $this->get('contact_email'); }

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
     * @param float $cashExtraCharge
     */
    public function setCashExtraCharge($cashExtraCharge)
    {
        $this->set('cash_extra_charge', $cashExtraCharge);
    }

    /**
     * @return float
     */
    public function getCashExtraCharge()
    {
        return $this->get('cash_extra_charge');
    }

    /**
     * @param string $decorationId
     * @return DecorationPrice
     */
    public function getDecorationPrice($decorationId)
    {
        return $this->getByKey('decoration_prices', $decorationId);
    }

    /**
     * @return DecorationPrice
     */
    public function getDecorationPrices()
    {
        return $this->get('decoration_prices');
    }

    /**
     * @param DecorationPrice $decorationPrice
     */
    public function addDecorationPrice(DecorationPrice $decorationPrice)
    {
        $this->add('decoration_prices', $decorationPrice);
    }

    /**
     * @param DecorationPrice $decorationPrice
     */
    public function removeDecorationPrice(DecorationPrice $decorationPrice)
    {
        $this->remove('decoration_prices', $decorationPrice);
    }

    /**
     *
     */
    public function removeDecorationPrices()
    {
        $this->removeAll('decoration_prices');
    }
}
