<?php

namespace Model;

class RecordFactory implements \PhotoCake\Db\Record\RecordFactoryInterface
{
    /**
     * @param string $collection
     * @param array $value
     * @return Admin|Bakery|City|Order|null
     */
    public function createForCollection($collection, array $value)
    {
        switch ($collection) {
            case 'users': return $this->createUser($value['role']);
            case 'cities': return new City();
            case 'orders': return new Order();
            case 'bakeries': return new Bakery();

        }

        return null;
    }

    /**
     * @param string $name
     * @param array $value
     * @return Admin|Bakery|City|Client|Delivery|Dimensions|Order|Payment|Recipe|null
     */
    public function createByName($name, array $value)
    {
        switch ($name) {
            case User::NAME: return $this->createUser($value['role']);

            case Admin::NAME: return new Admin();
            case Bakery::NAME: return new Bakery();

            case City::NAME: return new City();
            case Order::NAME: return new Order();
            case Recipe::NAME: return new Recipe();
            case Client::NAME: return new Client();
            case Payment::NAME: return new Payment();
            case Delivery::NAME: return new Delivery();
            case Dimension::NAME: return new Dimension();
            case DimensionPrice::NAME: return new DimensionPrice();
        }

        return null;
    }

    /**
     * @param int $role
     * @return Admin|Bakery|null
     */
    private function createUser($role)
    {
        switch ($role) {
            case User::ROLE_ADMIN: return new Admin();
            case User::ROLE_BAKERY: return new Bakery();
        }

        return null;
    }
}
