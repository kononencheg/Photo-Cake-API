<?php

namespace Api\Methods\Orders;

use \PhotoCake\Api\Arguments\Filter;

class Submit extends \PhotoCake\Api\Method\Method
{
    /**
     * @var \DateTime
     */
    private $targetDate = NULL;

    /**
     * @var array
     */
    protected $arguments = array(
        'photo' => Filter::BASE64,
        'image' => Filter::BASE64,
        'markup' => Filter::JSON,

        'recipe' => Filter::STRING,
        'bakery_id' => Filter::STRING,

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
            'name' => array( NULL => 'Имя не задано.' ),
            'phone' => array(
                NULL => 'Телефон не задан.',
                false => 'Телефон введен неправильно.'
            ),
            'email' => array(
                NULL => 'Email не задан.',
                false => 'Email введен не правильно.'
            ),

            'date' => array( NULL => 'Дата не задана.' ),
            'time' => array( -1 => 'Время не задано.' ),
            'city' => array( NULL => 'Город не задан.' ),
            'address' => array( NULL => 'Адрес не задан.' ),
        );

        if ($this->param('cake_image')) {
            $filter = array_merge($filter, array(
                'campaign' => array( NULL => 'Ошибка обработки данных.' ),

                'cake_price' => array( NULL => 'Ошибка обработки данных.' ),
                'cake_weight' => array( NULL => 'Ошибка обработки данных.' ),
                'cake_image' => array( NULL => 'Ошибка обработки данных.' ),
            ));
        } else {
            $filter = array_merge($filter, array(
                'image' => array( NULL => 'Ошибка обработки данных.' ),
                'markup' => array( NULL => 'Ошибка обработки данных.' ),

                'recipe' => array( NULL => 'Ошибка обработки данных.' ),
                'bakery_id' => array( NULL => 'Ошибка обработки данных.' ),
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

        $time = $this->targetDate->getTimestamp() + $this->param('time');

        $order = NULL;
        if ($this->param('cake_image')) {
            $order = $orders->submitCampaignOrder(
                $this->param('cake_image'), $this->param('cake_weight'),
                $this->param('cake_price'), $time, $this->param('address'),
                $this->param('email'), $this->param('name'),
                $this->param('phone'), $this->param('network'),
                $this->param('user_id'), $this->param('comment'),
                $this->param('message'), $this->param('campaign')
            );
        } else {
            $order = $orders->submitOrder(
                $this->param('image'), $this->param('photo'),
                $this->param('markup'), $this->param('email'),
                $this->param('name'), $this->param('phone'),
                $this->param('network'), $this->param('user_id'), $time,
                $this->param('address'),$this->param('bakery_id'),
                $this->param('recipe'), $this->param('comment'),
                $this->param('message'), $this->param('campaign')
            );
        }

        return $order->jsonSerialize();
    }
}
