<?php

namespace Api\Methods\Orders;

use \PhotoCake\Api\Arguments\Filter;

class Add extends \PhotoCake\Api\Method\Method
{
    /**
     * @var \DateTime
     */
    private $targetDate = null;

    /**
     * @var array
     */
    protected $arguments = array(
        'photo_base64' => Filter::BASE64,
        'image_base64' => Filter::BASE64,

        'markup_json' => Filter::JSON,

        'bakery_id' => Filter::STRING,
        'recipe' => Filter::STRING,

        'campaign' => Filter::STRING,
        'cake_id' => Filter::STRING,
        'cake_image' => Filter::URL,

        'name' => Filter::STRING,
        'phone' => Filter::PHONE,
        'email' => Filter::EMAIL,

        'network' => Filter::STRING,
        'user_id' => Filter::STRING,

        'date' => Filter::STRING,
        'time' => Filter::INTEGER,
        'address' => Filter::STRING,

        'message' => Filter::STRING,
        'comment' => Filter::STRING,
    );

    /**
     * @return void
     */
    protected function filter()
    {
        $filter = array(
            'name' => array( null => 'Имя не задано.' ),
            'phone' => array(
                null => 'Телефон не задан.',
                false => 'Телефон введен неправильно.'
            ),
            'email' => array(
                null => 'Email не задан.',
                false => 'Email введен не правильно.'
            ),

            'date' => array( null => 'Дата не задана.' ),
            'time' => array( -1 => 'Время не задано.' ),
            'city' => array( null => 'Город не задан.' ),
            'address' => array( null => 'Адрес не задан.' ),
        );

        if ($this->getParam('cake_image')) {
            $filter = array_merge($filter, array(
                'campaign' => array( null => 'Ошибка обработки данных.' ),

                'cake_price' => array( null => 'Ошибка обработки данных.' ),
                'cake_weight' => array( null => 'Ошибка обработки данных.' ),
                'cake_image' => array( null => 'Ошибка обработки данных.' ),
            ));
        } else {
            $filter = array_merge($filter, array(
                'image' => array( null => 'Ошибка обработки данных.' ),
                'markup' => array( null => 'Ошибка обработки данных.' ),

                'recipe' => array( null => 'Ошибка обработки данных.' ),
                'bakery_id' => array( null => 'Ошибка обработки данных.' ),
            ));
        }

        $this->applyFilter($filter, array(
            'date' => 'testDate'
        ));
    }

    protected function testDate($date)
    {
        $this->targetDate = \DateTime::createFromFormat('d.m.Y', $date);
        if ($this->targetDate !== false) {
            $this->targetDate->setTime(0, 0);

            $interval = new \DateInterval('P3D');

            $today = new \DateTime();
            $today->setTime(0, 0);
            $edgeDate = $today->add($interval);

            if ($this->targetDate->getTimestamp() < $edgeDate->getTimestamp()) {
                $this->response->addParamError
                    ('date', 'Срок обработки заказа минимум двое суток.');
            }
        } else {
            $this->response->addParamError
               ('date', 'Правильный формат даты "дд.мм.гггг".');
        }
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        $orders = new \Api\Resources\Orders();

        $time = $this->targetDate->getTimestamp() + $this->getParam('time');

        $order = null;
        if ($this->getParam('cake_image')) {
            $order = $orders->submitCampaignOrder(
                $this->getParam('cake_image'), $this->getParam('cake_weight'),
                $this->getParam('cake_price'), $time, $this->getParam('address'),
                $this->getParam('email'), $this->getParam('name'),
                $this->getParam('phone'), $this->getParam('network'),
                $this->getParam('user_id'), $this->getParam('comment'),
                $this->getParam('message'), $this->getParam('campaign')
            );
        } else {
            $order = $orders->submitOrder(
                $this->getParam('image'), $this->getParam('photo'),
                $this->getParam('markup'), $this->getParam('email'),
                $this->getParam('name'), $this->getParam('phone'),
                $this->getParam('network'), $this->getParam('user_id'), $time,
                $this->getParam('address'),$this->getParam('bakery_id'),
                $this->getParam('recipe'), $this->getParam('comment'),
                $this->getParam('message'), $this->getParam('campaign')
            );
        }

        return $order->jsonSerialize();
    }
}
