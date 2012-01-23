<?php

namespace Api\Resources;

class Clients extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param $email
     * @param $network
     * @param $networkId
     * @param $name
     * @param $phone
     * @return \Model\Client
     */
    public function initClient($email, $name, $phone, $network, $networkId)
    {
        $collection = $this->getCollection('clients');

        $client = $collection->createRecord();
        $client->email = $email;
        $client->name = $name;
        $client->phone = $phone;
        $client->network = $network;
        $client->network_id = $networkId;

        return $client;
    }
}
