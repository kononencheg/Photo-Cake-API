<?php

namespace Api\Resources;

use Model\Order;

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
     * @param string $bakeryId
     * @return \Iterator
     */
    public function getBakeryOrders($bakeryId)
    {
        return $this->getCollection('orders')
                    ->fetchAll(array( 'bakery._ref' => new \MongoId($bakeryId) ));
    }

    /**
     * @param \Model\Order $order
     * @return bool
     */
    public function emailOrder(\Model\Order $order)
    {
        $to = implode(', ', array(
            'kononencheg@gmail.com', 'visser@yandex.ru',
            $order->getClient()->getEmail()
        ));


        $headers  = 'MIME-Version: 1.0' ." \r\n" .
                    'Content-type: text/html; charset=utf-8' . "\r\n" .
                    'From: Тортовый оповещатель <noreply@fotonatorte.ru>' . "\r\n";

        return mail($to, 'Новый заказ', $this->getMailMarkup($order), $headers);
    }

    private function getMailMarkup(\Model\Order $order)
    {
        $recipe = $order->getRecipe();
        $payment = $order->getPayment();
        $cake = $order->getCake();
        $client = $order->getClient();
        $delivery = $order->getDelivery();
        $time = $delivery->getDate();

        $bakery = $order->getBakery();

        return '<html>
            <head>
                <title>Новый Заказ</title>
            </head>
            <body>
                <h1>Заказ</h1>

                <p> Вы заказли торт с помощью приложения Фото На Торте! Спасибо
                    вам огромное! Надеемся, что вам понравится! </p>

                <h2>Параметры заказа</h2>

                <table>
                    <tbody>' .
            $this->getRow('Ваше имя', $client->getName() .
            $this->getRow('Ваш телефон', $client->getPhone()) .
            $this->getRow('Город', $bakery->getCity()->getName()) .
            $this->getRow('Адрес доставки', $delivery->getAddress())) .
            $this->getRow('Дата доставки', date('d.m.Y (H:i', $time) . '-' .
                                           date('H:i)', $time + 7200)).

            $this->getRow('Торт', '<img alt="Торт" src="' . $cake->getImageUrl() . '" />') .

            $this->getRow('Изображения для печати', ($cake->getPhotoUrl() ?
                '<img alt="Изображения для печати" src="' . $cake->getPhotoUrl() . '" />' :
                'Изображение отсутствует')) .

            $this->getRow('Вес (кг.)', $cake->getDimension()->getWeight()) .
            $this->getRow('Рецепт', $recipe->getName()) .
            $this->getRow('Описание рецепта', $recipe->getDesc()) .
            $this->getRow('Комментарий', $delivery->getComment()) .
            $this->getRow('Записка', $delivery->getMessage()) .
            $this->getRow('Цена с доставкой (руб.)', $payment->getTotalPrice()) .'
                    </tbody>
                </table>

                <p> По указанному вами телефону в течении дня с вами свяжется
                    представитель компании для уточнения заказа. </p>
            </body>
        </html>';
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
