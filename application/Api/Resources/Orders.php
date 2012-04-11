<?php

namespace Api\Resources;

use Model\Order;
use Model\Delivery;

use Mail;
use PEAR;

class Orders extends \Api\Resources\Resource
{

    /**
     * @return \Model\Order
     */
    public function createOrder()
    {
        $order = $this->createRecord(Order::NAME);
        $order->setStatus(Order::ORDER_NEW);
        $order->setDeliveryStatus(Order::DELIVERY_NEW);
        $order->setPaymentStatus(Order::PAYMENT_NEW);

        return $order;
    }

    /**
     * @param \Model\Order $order
     */
    public function saveOrder(\Model\Order $order)
    {
        $this->getCollection('orders')->update($order);
    }

    /**
     * @param string $id
     * @return \Model\Order
     */
    public function getById($id)
    {
        return $this->getCollection('orders')->fetch($id);
    }

    /**
     * @param float $transactionId
     * @return boolean
     */
    public function checkTransactionId($transactionId) {
        $orders = $this->getCollection('orders')->fetchOne(
            array( 'payment.transaction_id' => $transactionId )
        );

        return $transactionId > 0 && $orders === null;
    }

    /**
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getBakeryOrders($bakeryId)
    {
        return $this->getCollection('orders')->fetchAll(
            array( 'bakery._ref' => new \MongoId($bakeryId) ),
            null, null,
            array( '_id' => -1 )
        );
    }

    /**
     * @param \Model\Order $order
     * @return string
     */
    public function printOrder(\Model\Order $order)
    {
        return $this->getMailMarkup($order);
    }

    /**
     * @param \Model\Order $order
     * @return bool
     */
    public function emailOrder(\Model\Order $order)
    {
        $to = 'kononencheg@gmail.com, visser@fotonatorte.ru, '.
            $order->getBakery()->getEmail();

        $clientEmail = $order->getClient()->getEmail();
        if ($clientEmail !== null) {
            $to .= ', ' . $clientEmail;
        }

        $headers = array (
            'From' => 'noreply@fotonatorte.ru ',
            'To' => $to,
            'Subject' => 'Новый заказ',
            'Content-type' => 'text/html; charset=utf-8',
            'MIME-Version' => '1.0'
        );

        $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'kononencheg@gmail.com',
            'password' => 'umnz picg ugpx eblu',
        ));

        $mail = $smtp->send($to, $headers, $this->getMailMarkup($order));

        return !PEAR::isError($mail);
    }

    private function getMailMarkup(\Model\Order $order)
    {
        $recipe = $order->getRecipe();
        $payment = $order->getPayment();
        $cake = $order->getCake();
        $client = $order->getClient();

        return '<html>
            <head>
                <title>Новый Заказ</title>
            </head>
            <body>
                <h1>Заказ ' . $order->getId() . '</h1>

                <p> Вы заказли торт с помощью приложения Фото На Торте! Спасибо
                    вам огромное! Надеемся, что вам понравится! </p>

                <h2>Параметры заказа</h2>

                <table border="1">
                    <tbody>' .

            $this->getRow('Имя', $client->getName() .
            $this->getRow('Телефон', $client->getPhone()) .

            $this->getDeliveryRows($order) .

            $this->getRow('Изображение торта', '<img src="' . $cake->getImageUrl() . '" />') .
            $this->getRow('Изображения для печати', '<img src="' . $cake->getPhotoUrl() . '" alt="Изображение отсутствует" />')) .
            $this->getRow('Вес (кг.)', $cake->getDimension()->getWeight()) .

            $this->getRow('Рецепт', $recipe->getName()) .
            $this->getRow('Описание рецепта', $recipe->getDesc()) .

            $this->getRow('Цена (руб.)', $payment->getTotalPrice()) .

                  '</tbody>
                </table>

                <p> По указанному вами телефону в течении дня с вами свяжется
                    представитель компании для уточнения заказа. </p>
            </body>
        </html>';
    }

    private function getDeliveryRows(\Model\Order $order) {
        $bakery = $order->getBakery();
        $delivery = $order->getDelivery();
        $time = $delivery->getDate();

        $date = date('d.m.Y (H:i', $time) . '-' . date('H:i)', $time + 7200);

        $result = $this->getRow('Город', $bakery->getCity()->getName());

        switch ($delivery->getType()) {
            case Delivery::TYPE_COURIER: {
                $result .= $this->getRow('Адрес доставки', $delivery->getAddress()) .
                           $this->getRow('Дата доставки', $date);
                break;
            }

            case Delivery::TYPE_PICKUP: {
                $result .= $this->getRow('Адрес пункта выдачи', $bakery->getAddress()) .
                           $this->getRow('Дата выдачи', $date);
                break;
            }
        }

        $result .= $this->getRow('Комментарий к доставке', $delivery->getComment()) .
                   $this->getRow('Записка к торту', $delivery->getMessage());

        return $result;
    }

    private function getRow($name, $value)
    {
        return '<tr><th>' . $name . ':</th><td>' . $value . '</td></tr>';
    }

    /**
     * @static
     * @var \Api\Resources\Orders
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Orders
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Orders();
        }

        return self::$instance;
    }
}
