<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

use Model\DecorationPrice;

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
    protected function extendOptions()
    {
        return array(
            'city' => City::NAME,
            'delivery_price' => 'float',
            'decoration_prices' =>  array( 'type' => DecorationPrice::NAME,
                                           'relation' => MongoRecord::RELATION_MANY,
                                           'key_field' => 'decoration_id' ),
        );
    }

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
}
