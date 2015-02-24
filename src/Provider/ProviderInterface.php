<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 12:28
 */

namespace ExchangeRates\Provider;

use ExchangeRates\Collection;
use ExchangeRates\Network\Client;


/**
 * Interface ProviderInterface
 * @package ExchangeRates\Provider
 */
interface ProviderInterface 
{
    /**
     * @param \DateTime $date
     * @return Collection
     * @throws Exception\ParsingFailedException
     */
    public function parse(\DateTime $date);

    /**
     * @param Client $networkClient
     * @return $this
     */
    public function setNetworkClient(Client $networkClient);
}