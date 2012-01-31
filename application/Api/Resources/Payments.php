<?php

namespace Api\Resources;


class Payments implements \PhotoCake\Api\Resource\ResourceInterface
{
    public function initPayment(\stdClass $markup,
                                \Model\Recipe $recipe,
                                \Model\Bakery $bakery)
    {
        $payment = new \Model\Payment();

        $decoPrice = $this->getDecorationPrice($markup);
        $recipePrice = $this->getRecipePrice($markup, $recipe);
        $deliveryPrice = $bakery->get('delivery_price');

        $payment->set('deco_price', $decoPrice);
        $payment->set('recipe_price', $recipePrice);
        $payment->set('delivery_price', $deliveryPrice);
        $payment->set
            ('total_price', $decoPrice + $recipePrice + $deliveryPrice);

        $payment->set('payment_type', \Model\Payment::CASH);

        return $payment;
    }

    private function getRecipePrice(\stdClass $markup, \Model\Recipe $recipe)
    {
        return $recipe->get('price') * $markup->dimensions->mass;
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
            case 'cherry': case 'grape': case 'kiwi': case 'raspberry':
            case 'strawberry': case 'orange': case 'peach': case 'lemon':
            case 'blueberry': case 'currant':
                return 10;

            case 'pig1': case 'car1': case 'hare1': case 'hedgehog1':
            case 'moose1': case 'owl1': case 'pin1': case 'sheep1':
            case 'raven1': case 'bear1': case 'car2': case 'car3': case 'mat1':
            case 'ia': case 'ladybug': case 'pig': case 'rabbit': case 'tiger':
            case 'winnie': case 'winnie1': case 'bootes':
                return 250;

            case 'doll1': case 'doll2':
                return 350;

            case 'flower1': case 'flower2':
                return 300;

            case 'flower3': case 'flower4': case 'flower5': case 'flower6':
            case 'physalis':
                return 200;

            default:
                return 0;
        }
    }
}
