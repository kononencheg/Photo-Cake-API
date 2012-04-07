<?php

namespace Model;

class Delivery extends \PhotoCake\Db\Mongo\MongoRecord
{

    /**
     * @const
     * @var int
     */
    const TYPE_COURIER = 0;

    /**
     * @const
     * @var int
     */
    const TYPE_PICKUP = 1;

    /**
     * @const
     * @var string
     */
    const NAME = 'delivery';

    /**
     * @var array
     */
    protected $options = array(
        'date' => 'int',
        'type' => 'int',

        'address' => 'string',
        'comment' => 'string',
        'message' => 'string',
    );


    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->set('address', $address);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->get('address');
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->set('comment', $comment);
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->get('comment');
    }

    /**
     * @param int $date
     */
    public function setDate($date)
    {
        $this->set('date', $date);
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->get('date');
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->set('type', $type);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->get('type');
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->set('message', $message);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->get('message');
    }
}
