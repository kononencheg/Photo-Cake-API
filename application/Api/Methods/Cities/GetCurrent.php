<?php

namespace Api\Methods\Cities;

use Api\Resources\Users;

use Api\Resources\Cities;

class GetCurrent extends \PhotoCake\Api\Method\Method
{
    /**
     * @return mixed
     */
    protected function apply()
    {
        $ip = '213.190.224.48'; // $_SERVER['REMOTE_ADDR']

        $request = curl_init();

        curl_setopt($request, CURLOPT_URL, 'http://ipgeobase.ru:7020/geo?ip=' . $ip);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $result = simplexml_load_string(curl_exec($request));
        $city = (string) $result->ip->city;

        if (empty($city)) {
            $city = 'Москва';
        }

        return array(
            'name' => $city
        );
    }
}
