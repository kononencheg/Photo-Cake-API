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
        $client->set('email', $email);
        $client->set('name', $name);
        $client->set('phone', $phone);
        $client->set('network', $network);
        $client->set('network_id', $networkId);

        return $client;
    }
}
