<?php

namespace Api\Resources;

class Clients extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param $email
     * @param $name
     * @param $phone
     * @param $network
     * @param $userId
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function createClient($email, $name, $phone, $network, $userId)
    {
        $collection = $this->getCollection('clients');

        $client = $collection->createRecord();
        $client->set('email', $email);
        $client->set('name', $name);
        $client->set('phone', $phone);
        $client->set('network', $network);
        $client->set('user_id', $userId);

        return $client;
    }
}
