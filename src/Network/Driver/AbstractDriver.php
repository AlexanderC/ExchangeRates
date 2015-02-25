<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:25
 */

namespace ExchangeRates\Network\Driver;

/**
 * Class AbstractDriver
 * @package ExchangeRates\Network\Driver
 *
 * @method string get($endpoint, array $parameters = [], array $headers = [])
 * @method string post($endpoint, array $data = [], array $headers = [])
 * @method string put($endpoint, array $data = [], array $headers = [])
 * @method string delete($endpoint, array $parameters = [], array $headers = [])
 * @method string head($endpoint, array $parameters = [], array $headers = [])
 * @method string options($endpoint, array $parameters = [], array $headers = [])
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * @param string $endpoint
     * @param array $parameters
     * @return string
     */
    protected function buildUrl($endpoint, array $parameters)
    {
        $queryString = http_build_query($parameters);
        $delimiter = false === strpos($endpoint, '?') ? '?' : '&';

        return $endpoint . $delimiter . $queryString;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function __call($name, array $arguments)
    {
        if(count($arguments) != 2) {
            throw new \BadMethodCallException("There should be exact 2 arguments: endpoint and parameters");
        }

        return $this->fetch($arguments[0], $arguments[1], strtoupper($name));
    }
}