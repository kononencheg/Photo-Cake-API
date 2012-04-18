<?php

namespace Model;

use PhotoCake\Db\Mongo\MongoRecord;

use Model\DecorationPrice;

class Partner extends User
{
    /**
     * @const
     * @var string
     */
    const NAME = 'partner';

    /**
     * @var array
     */
    protected $data = array(
        'role' => User::ROLE_PARTNER,
    );

    /**
     * @param array $fields
     * @return array
     */
    protected function extendOptions()
    {
        return array(
            'url' => 'string'
        );
    }

    /**
     * @var array
     */
    protected $spanFields = array(
        'orders' => array('url', 'name', '_ref'),
    );

    /**
     * @param string $url
     */
    public function setUrl($url) { $this->set('url', $url); }

    /**
     * @return string
     */
    public function getUrl() { return $this->get('url'); }

}
