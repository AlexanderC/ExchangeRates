<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:14
 */

namespace ExchangeRates;


use ExchangeRates\Helper\ArrayAccess;

/**
 * Class Collection
 * @package ExchangeRates
 */
class Collection extends ArrayAccess
{
    /**
     * @var ExchangeRate[]
     */
    protected $collection;

    /**
     * @param ExchangeRate[] $collection
     */
    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    /**
     * @param Collection $collection
     * @return $this
     */
    public function merge(Collection $collection)
    {
        foreach($collection as $exchangeRate) {
            $this->collection[] = $exchangeRate;
        }

        return $this;
    }

    /**
     * @return ExchangeRate[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return ExchangeRate[]
     */
    protected function & __arrayAccessCollection()
    {
        return $this->collection;
    }
}