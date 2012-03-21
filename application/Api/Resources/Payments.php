<?php

namespace Api\Resources;

use Model\Payment;


class Payments extends \Api\Resources\Resource
{
    /**
     * @param \Model\Bakery $bakery
     * @param string $markupJson
     * @return int
     */
    public function getDecorationPrice(\Model\Bakery $bakery, $markupJson)
    {
        $result = 0;

        $markup = json_decode($markupJson);
        if (isset($markup->content->deco)) {
            $deco = $markup->content->deco;

            foreach ($deco as $item) {
                $result += $bakery->getDecorationPrice($item->name)->getPrice();
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

    ///////////////////////////////////////////////////////////////////////////

    /**
     * @param \Model\Recipe $recipe
     * @param \Model\Dimension $dimension
     * @return float
     */
    public function getRecipePrice(\Model\Recipe $recipe,
                                   \Model\Dimension $dimension)
    {
        $price = $recipe->getDimensionPriceByWeight($dimension->getWeight());
        if ($price !== null) {
            return $price->getPrice();
        }

        return 0;
    }

    /**
     * @return \Model\Payment
     */
    public function createPayment()
    {
        $payment = $this->createRecord(Payment::NAME);
        $payment->setPaymentMethod(Payment::METHOD_NONE);

        return $payment;
    }

    /**
     * @static
     * @var \Api\Resources\Payments
     */
    private static $instance;

    /**
     * @static
     * @return \Api\Resources\Payments
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Payments();
        }

        return self::$instance;
    }

}
