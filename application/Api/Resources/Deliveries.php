<?php

namespace Api\Resources;

class Deliveries extends \PhotoCake\Api\Resource\DbResource
{

    public function initDelivery(\Model\City $city, $address, $time)
    {
        $delivery = new \Model\Delivery();
        $delivery->set('city', $city);
        $delivery->set('address', $address);
        $delivery->set('date', new \MongoDate($time));

        return $delivery;
    }
}
