<?php

namespace Api\Resources;

use Model\Order;

class Orders extends \Api\Resources\Resource
{

    /*public function emailOrder(\Model\Order $order)
    {
        $to = implode(', ', array(
            'kononencheg@gmail.com', 'visser@yandex.ru',
            'visser@creat-present.ru',
            $order->get('client')->get('email')
        ));

        // subject
        $subject = 'Новый заказ';

        // message
        $message = $this->getMailMarkup($order);

        $headers  = 'MIME-Version: 1.0' ." \r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Тортовый оповещатель <noreply@fotonatorte.ru>' . "\r\n";

        return mail($to, $subject, $message, $headers);
    }

    private function getMailMarkup(\Model\Order $order)
    {
        $recipe = $order->get('recipe');
        $payment = $order->get('payment');
        $cake = $order->get('cake');
        $client = $order->get('client');
        $delivery = $order->get('delivery');
        $time = $delivery->get('date')->sec;

        $bakery = $order->get('bakery');

        return '<html>
            <head>
                <title>Новый Заказ</title>
            </head>
            <body>
                <h1>Заказ</h1>

                <p> Вы заказли торт с помощью приложения Фото На Торте! Спасибо
                    вам огромное! Надеемся, что вам понравится! </p>

                <h2>Параметры заказа</h2>

                <table><tbody>' .
                    $this->getRow('Ваше имя', $client->get('name')) .
                    $this->getRow('Ваш телефон', $client->get('phone')) .
         ($bakery ? $this->getRow('Город', $bakery->get('city')->get('name')) : '') .
                    $this->getRow('Адрес доставки', $delivery->get('address')) .
                    $this->getRow('Дата доставки', date('d.m.Y (H:i', $time) . '-' . date('H:i)', $time + 7200)).
                    $this->getRow('Торт', '<img alt="Торт" src="' . $cake->get('image_url') . '" />') .
                    $this->getRow('Изображения для печати', ($cake->get('photo_url') ?
                                    '<img alt="Изображения для печати" src="' . $cake->get('photo_url') . '" />' :
                                    'Изображение отсутствует')) .
                    $this->getRow('Вес (кг.)', $cake->get('weight')) .
         ($recipe ? $this->getRow('Рецепт', $recipe->get('name')) : '') .
         ($recipe ? $this->getRow('Описание рецепта', $recipe->get('desc')) : '') .
                    $this->getRow('Комментарий', $order->get('comment')) .
                    $this->getRow('Записка', $order->get('message')) .
                    $this->getRow('Цена с доставкой (руб.)', $payment->get('total_price')) .
                '</tbody></table>

                <p> По указанному вами телефону в течении дня с вами свяжется
                    представитель компании для уточнения заказа. </p>
            </body>
        </html>';
    }

    private function getRow($name, $value)
    {
        return '<tr><td><b>' . $name . ':</b></td><td>' . $value . '</td></tr>';
    }
*/

    ////////////////////////////////////////////////////////////////////////

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
     * @param int $method
     */
    public function updatePaymentMethod(Order $order, $method)
    {
        $order->getPayment()->setPaymentMethod($method);
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
                    ->fetchAll(array( 'bakery_id' => $bakeryId ));
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
