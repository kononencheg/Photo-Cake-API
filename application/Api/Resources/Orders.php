<?php

namespace Api\Resources;

class Orders extends \PhotoCake\Api\Resource\DbResource
{
    /**
     * @param \Model\Cake $cake
     * @param \Model\Recipe $recipe
     * @param \Model\Client $client
     * @param \Model\Delivery $delivery
     * @param \Model\Payment $payment
     * @param string $comment
     * @return \Model\Order
     */
    public function initOrder(\Model\Cake $cake,
                              \Model\Recipe $recipe,
                              \Model\Client $client,
                              \Model\Delivery $delivery,
                              \Model\Payment $payment, $comment)
    {
        $collection = $this->getCollection('orders');

        $order = $collection->createRecord();
        $order->set('cake', $cake);
        $order->set('recipe', $recipe);
        $order->set('client', $client);
        $order->set('delivery', $delivery);
        $order->set('payment', $payment);
        $order->set('comment', $comment);

        $collection->update($order);

        return $order;
    }

    public function emailOrder(\Model\Order $order) {
        $to = implode(', ', array(
            'kononencheg@gmail.com', 'visser@yandex.ru',
            'visser@creat-present.ru',
            $order->client->email
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

    private function getMailMarkup(\Model\Order $order) {
        $time = $order->delivery->date->sec;

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
                    $this->getRow('Ваше имя', $order->client->name) .
                    $this->getRow('Ваш телефон', $order->client->phone) .
                    $this->getRow('Город', $order->delivery->city->name) .
                    $this->getRow('Адрес доставки', $order->delivery->address) .
                    $this->getRow('Дата доставки', date('d.m.Y (H:i', $time) . '-' . date('H:i)', $time + 7200)).
                    $this->getRow('Торт', '<img alt="Торт" src="' . $order->cake->image_url . '" />') .
                    $this->getRow('Изображения для печати', ($order->cake->photo_url ?
                                    '<img alt="Изображения для печати" src="' . $order->cake->photo_url . '" />' :
                                    'Изображение отсутствует')) .
                    $this->getRow('Вес (кг.)', $order->cake->weight) .
                    $this->getRow('Рецепт', $order->recipe->title) .
                    $this->getRow('Описание рецепта', $order->recipe->desc) .
                    $this->getRow('Комментарий', $order->comment) .
                    $this->getRow('Цена с доставкой (руб.)', $order->payment->total_price) .
                '</tbody></table>

                <p> По указанному вами телефону в течении дня с вами свяжется
                    представитель компании для уточнения заказа. </p>
            </body>
        </html>';
    }


    private function getRow($name, $value) {
        return '<tr><td><b>' . $name . ':</b></td><td>' . $value . '</td></tr>';
    }
}
