<?php

namespace Api\Resources;

use Model\Delivery;

class Deliveries extends \Api\Resources\Resource
{

    /**
     * @param int $date
     * @param int $type
     * @param string $address
     * @param string $comment
     * @param string $message
     * @return \Model\Delivery
     */
    public function createDelivery($type, $date, $address, $comment,
                                   $message)
    {
        $delivery = $this->createRecord(\Model\Delivery::NAME);
        $delivery->setDate($date);
        $delivery->setType($type);
        $delivery->setAddress($address);
        $delivery->setComment($comment);
        $delivery->setMessage($message);

        return $delivery;
    }

    /**
     * @param string $date
     * @param int $time
     * @return int
     */
    public function testDate($date, $time)
    {
        $resultDate = \DateTime::createFromFormat('d.m.Y', $date);

        if ($resultDate !== false) {
            $resultDate->setTime(0, 0);

            $interval = new \DateInterval('P3D');

            $today = new \DateTime();
            $today->setTime(0, 0);
            $edgeDate = $today->add($interval);

            if ($resultDate->getTimestamp() >= $edgeDate->getTimestamp()) {
                return $time + $resultDate->getTimestamp();
            }
        } else {
            return -1;
        }

        return null;
    }

    /**
     * @static
     * @var \Api\Resources\Deliveries
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Deliveries
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Deliveries();
        }

        return self::$instance;
    }
}
