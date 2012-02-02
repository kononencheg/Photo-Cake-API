<?php

namespace Api\Resources;

class Deliveries extends \PhotoCake\Api\Resource\DbResource
{

    public function createDelivery($address, $time)
    {
        $delivery = new \Model\Delivery();
        $delivery->set('address', $address);
        $delivery->set('date', new \MongoDate($time));

        return $delivery;
    }
}
