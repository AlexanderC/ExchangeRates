<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 12:10
 */

namespace ExchangeRates\Provider;

use ExchangeRates\Collection;


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