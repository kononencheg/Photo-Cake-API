<?php

namespace Api\Resources;

use \PhotoCake\Http\Session;

class Application implements \PhotoCake\Api\Resource\ResourceInterface
{
    /**
     * @var \PhotoCake\Http\Session
     */
    private $session = NULL;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    /**
     * @param string $network
     * @param array $options
     */
    public function setupNetworkEnvironment($network, array $options = array())
    {
        $this->session->set('network', $network);

        switch ($network) {
            case 'vk': {
                $this->setupVkEnvironment($options);
                break;
            }

            case 'ok': {
                break;
            }
        }
    }

    /**
     * @return string
     */
    public function getNetworkName()
    {
        return $this->session->get('network');
    }

    /**
     * @return string
     */
    public function getNetworkUserId()
    {
        return $this->session->get('network_user_id');
    }

    /**
     * @return array
     */
    public function getNetworkOptions()
    {
        return $this->session->get('network_options');
    }

    /**
     * @param array $options
     */
    private function setupVkEnvironment(array $options)
    {
        $this->session->set('network_user_id', $options['viewer_id']);
        $this->session->set('network_options', $options);
    }
}
