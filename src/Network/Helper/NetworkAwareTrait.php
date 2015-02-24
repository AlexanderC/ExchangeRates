<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:33
 */

namespace ExchangeRates\Network\Helper;

use ExchangeRates\Network\Client;

/**
 * Class NetworkAwareTrait
 * @package ExchangeRates\Helper\Network
 */
trait NetworkAwareTrait
{
    /**
     * @var Client
     */
    protected $networkClient;

    /**
     * @return Client
     */
    public function getNetworkClient()
    {
        return $this->networkClient;
    }

    /**
     * @param Client $networkClient
     * @return $this
     */
    public function setNetworkClient(Client $networkClient)
    {
        $this->networkClient = $networkClient;
        return $this;
    }
}