<?php

namespace Api\Resources;

use PhotoCake\Db\Configuration\ConfigurationManager;
use PhotoCake\Http\Session;

class Resource implements \PhotoCake\Api\Resource\ResourceInterface
{
    /**
     * @var \PhotoCake\Db\Collection\CollectionFactoryInterface
     */
    protected $collectionFactory = null;

    /**
     * @var \Model\RecordFactory
     */
    protected $recordFactory = null;

    /**
     * @var \PhotoCake\Http\Session
     */
    protected $session = null;

    protected function __construct()
    {
        $config = ConfigurationManager::getInstance()
                        ->getDefaultConfiguration();

        $this->collectionFactory = $config->getCollectionFactory();
        $this->recordFactory = $config->getRecordFactory();
        $this->session = Session::getInstance();
    }

    /**
     * @param $name
     * @return \Model\Admin|\Model\Bakery|\Model\Cake|\Model\City|\Model\Client|\Model\Delivery|\Model\Dimension|\Model\DimensionPrice|\Model\Order|\Model\Payment|\Model\Recipe|null
     */
    protected function createRecord($name)
    {
        return $this->recordFactory->createByName($name, array());
    }

    /**
     * @param string $name
     * @return \PhotoCake\Db\Collection\CollectionInterface
     */
    protected function getCollection($name)
    {
        return $this->collectionFactory->create($name);
    }

    /**
     * @return \Api\Resources\Users
     */
    protected function getUsers() { return Users::getInstance(); }

    /**
     * @return \Api\Resources\Orders
     */
    protected function getOrders() { return Orders::getInstance(); }
}
