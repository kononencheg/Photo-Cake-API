<?php

namespace Api\Resources;


class Payments implements \PhotoCake\Api\Resource\ResourceInterface
{
    public function initPayment(\stdClass $markup,
                                \Model\Recipe $recipe,
                                \Model\Delivery $delivery)
    {
        $payment = new \Model\Payment();

        $payment->deco_price = $this->getDecorationPrice($markup);
        $payment->recipe_price = $this->getRecipePrice($markup, $recipe);
        $payment->delivery_price = $this->getDeliveryPrice($delivery);

        $payment->total_price = $payment->deco_price +
                                    $payment->recipe_price +
                                    $payment->delivery_price;

        $payment->payment_type = \Model\Payment::CASH;

        return $payment;
    }

    private function getDeliveryPrice(\Model\Delivery $delivery)
    {
        return 450;
    }

    private function getRecipePrice(\stdClass $markup, \Model\Recipe $recipe)
    {
        return $recipe->price * $markup->dimensions->mass;
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
}
