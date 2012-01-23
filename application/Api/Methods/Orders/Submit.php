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

        'name' => Filter::STRING,
        'phone' => Filter::PHONE,
        'email' => Filter::EMAIL,

        'date' => Filter::STRING,
        'time' => Filter::INTEGER,
        'city' => Filter::STRING,
        'address' => Filter::STRING,

        'comment' => Filter::STRING,
    );

    /**
     * @return void
     */
    protected function filter()
    {
        $this->applyFilter(array(
            'image' => array( NULL => 'Ошибка обработки данных торта.' ),
            'markup' => array( NULL => 'Ошибка обработки данных торта.' ),
            'recipe' => array( NULL => 'Ошибка обработки данных торта.' ),

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
        $cities = new \Api\Resources\Cities();
        $clients = new \Api\Resources\Clients();
        $orders = new \Api\Resources\Orders();
        $payments = new \Api\Resources\Payments();
        $recipes = new \Api\Resources\Recipes();
        $deliveries = new \Api\Resources\Deliveries();

        $cake = $cakes->initCake($this->image, $this->photo, $this->markup);
        $client = $clients->initClient(
            $this->email, $this->name, $this->phone,
            $application->getNetworkName(),
            $application->getNetworkUserId()
        );

        $time = $this->targetDate->getTimestamp() + $this->time;
        $city = $cities->getById($this->city);

        $delivery = $deliveries->initDelivery($city, $this->address, $time);

        $recipe = $recipes->getByName($this->recipe);
        $payment = $payments->initPayment($this->markup, $recipe, $delivery);

        $order = $orders->initOrder
            ($cake, $recipe, $client, $delivery, $payment, $this->comment);

        return $orders->emailOrder($order);
    }
}
