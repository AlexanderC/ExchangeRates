<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:34
 */

namespace ExchangeRates;


use Doctrine\Common\Inflector\Inflector;
use ExchangeRates\Network\Client as NetworkClient;

/**
 * Class Client
 * @package ExchangeRates
 *
 * @method Collection parse(\DateTime $date)
 */
class Client
{
    /**
     * @var Provider\ProviderInterface
     */
    protected $provider;

    /**
     * @var Network\Client
     */
    protected $network;

    /**
     * @param Provider\ProviderInterface $provider
     * @param Network\Client $network
     */
    function __construct(Provider\ProviderInterface $provider, Network\Client $network)
    {
        $this->provider = $provider;
        $this->network = $network;

        $provider->setNetworkClient($network);
    }

    /**
     * @return Provider\AbstractProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return NetworkClient
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param string $providerName
     * @param string $networkDriverName
     * @return static
     */
    public static function create($providerName, $networkDriverName = null)
    {
        $providerClass = sprintf(__NAMESPACE__ . "\\Provider\\%sProvider", Inflector::classify($providerName));
        $provider = new $providerClass();
        $networkClient = NetworkClient::create($networkDriverName);

        return new static($provider, $networkClient);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    function __call($name, array $arguments)
    {
        return call_user_func_array([$this->provider, $name], $arguments);
    }
}