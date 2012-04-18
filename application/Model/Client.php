<?php

namespace Model;

class Client extends \PhotoCake\Db\Mongo\MongoRecord
{
    /**
     * @const
     * @var string
     */
    const NAME = 'client';

    /**
     * @const
     * @var int
     */
    const NETWORK_NONE = 0;

    /**
     * @const
     * @var int
     */
    const NETWORK_VK = 1;

    /**
     * @const
     * @var int
     */
    const NETWORK_OK = 2;

    /**
     * @var string
     */
    protected $collection = 'clients';

    /**
     * @var array
     */
    protected $options = array(
        'name' => 'string',

        'email' => 'string',
        'phone' => 'string',
    );

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->set('email', $email);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->set('name', $name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->set('phone', $phone);
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->get('phone');
    }
}
