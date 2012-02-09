<?php

namespace Api\Resources;

use Model\Payment;


class Payments implements \PhotoCake\Api\Resource\ResourceInterface
{
    public function getDecorationPrice(\stdClass $markup)
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

    ///////////////////////////////////////////////////////////////////////////

    /**
     * @param \Model\Recipe $recipe
     * @param \Model\Dimension $dimension
     * @return int
     */
    public function getRecipePrice(\Model\Recipe $recipe,
                                   \Model\Dimension $dimension)
    {
        $l = $recipe->getDimentionPricesCount();
        $i = 0;

        while ($i < $l) {
            $price = $recipe->getDimentionPriceAt($i);
            if ($price->getDimensionId() == $dimension->getId()){
                return $price->getPrice();
            }

            $i++;
        }

        return 0;
    }

    /**
     * @return \Model\Payment
     */
    public function createPayment()
    {
        $payment = new \Model\Payment();
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
