<?php

namespace Api\Resources;

class Deliveries extends \PhotoCake\Api\Resource\DbResource
{

    public function initDelivery(\Model\City $city, $address, $time)
    {
        $delivery = new \Model\Delivery();
        $delivery->city = $city;
        $delivery->address = $address;
        $delivery->date = new \MongoDate($time);

        return $delivery;
    }
}
