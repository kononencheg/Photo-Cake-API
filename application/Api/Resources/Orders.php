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
                              \Model\Bakery $bakery,
                              \Model\Payment $payment,
                              \Model\Delivery $delivery,
                              $comment, $message)
    {
        $collection = $this->getCollection('orders');

        $order = $collection->createRecord();
        $order->set('cake', $cake);
        $order->set('recipe', $recipe);
        $order->set('client', $client);
        $order->set('delivery', $delivery);
        $order->set('bakery', $bakery);

        $order->set('comment', $comment);
        $order->set('message', $message);

        $order->set('payment', $payment);

        $collection->update($order);

        return $order;
    }

    private function getDecorationPrice(\stdClass $markup)
    {
        $result = 0;

        if (isset($markup->content->deco)) {
            $deco = $markup->content->deco;

            foreach ($deco as $item) {
                $result += $this->getDecorationItemPrice($item->name);
            }
        }

        return $result;
    }

    private function getDecorationItemPrice($name)
    {
        switch ($name) {
            case 'cherry':
            case 'grape':
            case 'kiwi':
            case 'raspberry':
            case 'strawberry':
            case 'orange':
            case 'peach':
            case 'lemon': return 10;

            case 'pig1':
            case 'car1':
            case 'hare1':
            case 'hedgehog1':
            case 'moose1':
            case 'owl1':
            case 'pin1':
            case 'sheep1':
            case 'raven1':
            case 'bear1':
            case 'car2':
            case 'car3':
            case 'mat1': return 250;

            case 'doll1':
            case 'doll2': return 350;

            case 'flower1':
            case 'flower2': return 300;

            case 'flower3':
            case 'flower4':
            case 'flower5':
            case 'flower6': return 200;
        }

        return 0;
    }

    public function emailOrder(\Model\Order $order)
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

    private function getMailMarkup(\Model\Order $order) {
        $recipe = $order->get('recipe');
        $payment = $order->get('payment');
        $cake = $order->get('cake');
        $client = $order->get('client');
        $delivery = $order->get('delivery');
        $time = $delivery->get('date')->sec;

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
                    $this->getRow('Город', $delivery->get('city')->get('name')) .
                    $this->getRow('Адрес доставки', $delivery->get('address')) .
                    $this->getRow('Дата доставки', date('d.m.Y (H:i', $time) . '-' . date('H:i)', $time + 7200)).
                    $this->getRow('Торт', '<img alt="Торт" src="' . $cake->get('image_url') . '" />') .
                    $this->getRow('Изображения для печати', ($cake->get('photo_url') ?
                                    '<img alt="Изображения для печати" src="' . $cake->get('photo_url') . '" />' :
                                    'Изображение отсутствует')) .
                    $this->getRow('Вес (кг.)', $cake->get('weight')) .
                    $this->getRow('Рецепт', $recipe->get('name')) .
                    $this->getRow('Описание рецепта', $recipe->get('desc')) .
                $this->getRow('Комментарий', $order->get('comment')) .
                $this->getRow('Записка', $order->get('message')) .
                    $this->getRow('Цена с доставкой (руб.)', $payment->get('total_price')) .
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
