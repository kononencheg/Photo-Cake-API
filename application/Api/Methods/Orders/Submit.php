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
        $this->applyFilter(array(
            'image' => array( NULL => 'Ошибка обработки данных.' ),
            'markup' => array( NULL => 'Ошибка обработки данных.' ),

            'recipe' => array( NULL => 'Ошибка обработки данных.' ),
            'bakery_id' => array( NULL => 'Ошибка обработки данных.' ),

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
        ), array(
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
        $application = new \Api\Resources\Application();

        $cakes = new \Api\Resources\Cakes();
        $clients = new \Api\Resources\Clients();
        $orders = new \Api\Resources\Orders();
        $recipes = new \Api\Resources\Recipes();
        $deliveries = new \Api\Resources\Deliveries();
        $bakeries = new \Api\Resources\Bakeries();
        $payments = new \Api\Resources\Payments();

        $cake = $cakes->initCake($this->param('image'),
                                 $this->param('photo'),
                                 $this->param('markup'));

        $client = $clients->initClient(
            $this->param('email'), $this->param('name'), $this->param('phone'),
            $this->param('network'), $this->param('user_id')
        );

        $time = $this->targetDate->getTimestamp() + $this->param('time');
        $bakery = $bakeries->getById($this->param('bakery_id'));

        $delivery = $deliveries->initDelivery
            ($bakery->get('city'), $this->param('address'), $time);

        $recipe = $recipes->getByName
            ($this->param('bakery_id'), $this->param('recipe'));

        $payment = $payments->initPayment
            ($this->param('markup'), $recipe, $bakery);

        $order = $orders->initOrder($cake, $recipe, $client, $bakery,
                                    $payment, $delivery,
                                    $this->param('comment'),
                                    $this->param('message'));

        return $orders->emailOrder($order);
    }
}
