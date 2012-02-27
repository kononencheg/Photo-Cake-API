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
        $result = null;

        switch ($collection) {
            case 'users': $result = $this->createUser($value['role']); break;
            case 'cities': $result = new City(); break;
            case 'orders': $result = new Order(); break;
            case 'bakeries': $result = new Bakery(); break;
            case 'recipes': $result = new Recipe(); break;
            case 'dimensions': $result = new Dimension(); break;
            case 'cakes': $result = new Cake(); break;
        }

        if ($result !== null) {
            $result->setRecordFactory($this);
        }

        return $result;
    }

    /**
     * @param $name
     * @param array $value
     * @return Admin|Bakery|Cake|City|Client|Delivery|Dimension|DimensionPrice|Order|Payment|Recipe|null
     */
    public function createByName($name, array $value)
    {
        $result = null;

        switch ($name) {
            case User::NAME: $result = $this->createUser($value['role']); break;

            case Admin::NAME: $result = new Admin(); break;
            case Bakery::NAME: $result = new Bakery(); break;

            case City::NAME: $result = new City(); break;
            case Cake::NAME: $result = new Cake(); break;
            case Order::NAME: $result = new Order(); break;
            case Recipe::NAME: $result = new Recipe(); break;
            case Client::NAME: $result = new Client(); break;
            case Payment::NAME: $result =  new Payment(); break;
            case Delivery::NAME: $result = new Delivery(); break;
            case Dimension::NAME: $result = new Dimension(); break;
            case DimensionPrice::NAME: $result = new DimensionPrice(); break;
        }

        if ($result !== null) {
            $result->setRecordFactory($this);
        }

        return $result;
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

    /**
     * @param string $name
     * @return boolean
     */
    function isRecordExist($name)
    {
        switch ($name) {
            case User::NAME:
            case Cake::NAME:
            case Admin::NAME:
            case Bakery::NAME:
            case City::NAME:
            case Order::NAME:
            case Recipe::NAME:
            case Client::NAME:
            case Payment::NAME:
            case Delivery::NAME:
            case Dimension::NAME:
            case DimensionPrice::NAME:
                return true;
        }

        return false;
    }
}
