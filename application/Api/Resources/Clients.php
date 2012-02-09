<?php

namespace Api\Resources;

class Clients extends \Api\Resources\Resource
{
    /**
     * @param string $email
     * @param string $name
     * @param string $phone
     * @param int $network
     * @param string $networkId
     * @return \Model\Client
     */
    public function createClient($email, $name, $phone, $network, $networkId)
    {
        $client = new \Model\Client();
        $client->setEmail($email);
        $client->setName($name);
        $client->setPhone($phone);
        $client->setNetwork($network);
        $client->setNetworkId($networkId);

        return $client;
    }

    /**
     * @static
     * @var \Api\Resources\Clients
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Clients
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Clients();
        }

        return self::$instance;
    }
}
