<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 12:10
 */

namespace ExchangeRates\Provider;

use ExchangeRates\Collection;
use ExchangeRates\Network\Client;


/**
 * Class MultiProvider
 * @package ExchangeRates\Provider
 */
class MultiProvider extends AbstractProvider
{
    /**
     * @var \SplObjectStorage|AbstractProvider[]
     */
    protected $providers;

    /**
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = new \SplObjectStorage();

        foreach($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @param Client $networkClient
     * @return $this
     */
    public function setNetworkClient(Client $networkClient)
    {
        foreach($this->providers as $provider) {
            if(!$provider->getNetworkClient()) {
                $provider->setNetworkClient($networkClient);
            }
        }

        $this->networkClient = $networkClient;
        return $this;
    }

    /**
     * @param string $providerName
     * @return MultiProvider
     */
    public function createAndAddProvider($providerName)
    {
        return $this->addProvider(Factory::create($providerName));
    }

    /**
     * @return AbstractProvider[]
     */
    public function getProviders()
    {
        foreach($this->providers as $provider) {
            yield $provider;
        }
    }

    /**
     * @param AbstractProvider $provider
     * @return bool
     */
    public function containsProvider(AbstractProvider $provider)
    {
        return $this->providers->contains($provider);
    }

    /**
     * @param AbstractProvider $provider
     * @return bool
     */
    public function removeProvider(AbstractProvider $provider)
    {
        if(!$this->containsProvider($provider)) {
            throw new \OutOfBoundsException("There in no such provider");
        }

        $this->providers->detach($provider);
        return $this;
    }

    /**
     * @param AbstractProvider $provider
     * @return $this
     */
    public function addProvider(AbstractProvider $provider)
    {
        if($this->containsProvider($provider)) {
            throw new \BadMethodCallException("Such provider already exists");
        }

        if(!$provider->getNetworkClient() && $this->getNetworkClient()) {
            $provider->setNetworkClient($this->getNetworkClient());
        }

        $this->providers->attach($provider);
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return Collection
     * @throws Exception\ParsingFailedException
     */
    public function parse(\DateTime $date)
    {
        $collection = new Collection();

        foreach($this->providers as $provider) {
            $collection->merge($provider->parse($date));
        }

        return $collection;
    }
}