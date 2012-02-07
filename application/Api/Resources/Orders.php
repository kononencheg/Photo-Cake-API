<?php

namespace Api\Resources;

class Orders extends Resource
{
    /**
     * @param $image
     * @param $photo
     * @param $markup
     * @param $email
     * @param $name
     * @param $phone
     * @param $network
     * @param $userId
     * @param $time
     * @param $address
     * @param $bakeryId
     * @param $recipe
     * @param $comment
     * @param $message
     * @param $campaign
     * @return \Model\Order
     */
    public function submitOrder($image, $photo, $markup,
                                $email, $name, $phone, $network, $userId,
                                $time, $address, $bakeryId, $recipe,
                                $comment, $message, $campaign)
    {
        $cakes = new \Api\Resources\Cakes();
        $clients = new \Api\Resources\Clients();
        $recipes = new \Api\Resources\Recipes();
        $deliveries = new \Api\Resources\Deliveries();
        $bakeries = new \Api\Resources\Bakeries();
        $payments = new \Api\Resources\Payments();

        $bakery = $bakeries->getById($bakeryId);
        $recipe = $recipes->getByName($bakeryId, $recipe);

        $cake = $cakes->createCake($image, $photo, $markup);
        $payment = $payments->createPayment($markup, $recipe, $bakery);
        $delivery = $deliveries->createDelivery($address, $time);
        $client = $clients->createClient($email, $name, $phone, $network,
                                         $userId);

        $order = $this->createOrder($cake, $recipe, $client, $bakery, $payment,
                                    $delivery, $comment, $message, $campaign);

        $this->saveOrder($order);

        if ($this->emailOrder($order)) {
            return $order;
        }

        return null;
    }

    /**
     * @param $imageUrl
     * @param $weight
     * @param $price
     * @param $time
     * @param $address
     * @param $email
     * @param $name
     * @param $phone
     * @param $network
     * @param $userId
     * @param $comment
     * @param $message
     * @param $campaign
     * @return \Model\Order
     */
    public function submitCampaignOrder($imageUrl, $weight, $price, $time,
                                        $address, $email, $name, $phone,
                                        $network, $userId, $comment, $message,
                                        $campaign)
    {
        $cakes = new \Api\Resources\Cakes();
        $clients = new \Api\Resources\Clients();
        $deliveries = new \Api\Resources\Deliveries();
        $payments = new \Api\Resources\Payments();

        $cake = $cakes->createCampaignCake($imageUrl, $weight);
        $payment = $payments->createCampaignPayment($price);
        $delivery = $deliveries->createDelivery($address, $time);
        $client = $clients->createClient($email, $name, $phone, $network,
                                         $userId);

        $order = $this->createCampaignOrder($cake, $client, $payment, $delivery,
                                            $comment, $message, $campaign);

        $this->saveOrder($order);

        if ($this->emailOrder($order)) {
            return $order;
        }

        return null;
    }


    /**
     * @param \Model\Order $order
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function saveOrder(\Model\Order $order)
    {
        $this->getCollection('orders')->update($order);
    }

    /**
     * @param \Model\Cake $cake
     * @param \Model\Recipe $recipe
     * @param \Model\Client $client
     * @param \Model\Bakery $bakery
     * @param \Model\Payment $payment
     * @param \Model\Delivery $delivery
     * @param $comment
     * @param $message
     * @param $campaign
     * @return \PhotoCake\Db\Record\RecordInterface
     */
    public function createOrder(\Model\Cake $cake, \Model\Recipe $recipe,
                                \Model\Client $client, \Model\Bakery $bakery,
                                \Model\Payment $payment,
                                \Model\Delivery $delivery,
                                $comment, $message, $campaign)
    {
        $order = $this->getCollection('orders')->createRecord();
        $order->set('cake', $cake);
        $order->set('recipe', $recipe);
        $order->set('client', $client);
        $order->set('delivery', $delivery);
        $order->set('bakery', $bakery);

        $order->set('comment', $comment);
        $order->set('message', $message);
        $order->set('campaign', $campaign);

        $order->set('payment', $payment);

        return $order;
    }


    public function createCampaignOrder(\Model\Cake $cake,
                                        \Model\Client $client,
                                        \Model\Payment $payment,
                                        \Model\Delivery $delivery,
                                        $comment, $message, $campaign)
    {
        $order = $this->ordersCollection->createRecord();
        $order->set('cake', $cake);
        $order->set('client', $client);
        $order->set('delivery', $delivery);

        $order->set('comment', $comment);
        $order->set('message', $message);
        $order->set('campaign', $campaign);

        $order->set('payment', $payment);

        return $order;
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
}
