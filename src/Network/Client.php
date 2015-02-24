<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:28
 */

namespace ExchangeRates\Network;

use ExchangeRates\Network\Driver\DriverInterface;
use ExchangeRates\Network\Driver\Factory;

/**
 * Class Client
 * @package ExchangeRates\Network
 * @method string fetch($endpoint, array $parameters, $method = Driver\AbstractDriver::GET)
 */
class Client
{
    const DEFAULT_DRIVER = 'curl';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $driverName
     * @return static
     */
    public static function create($driverName = null)
    {
        return new static(Factory::create($driverName ?: self::DEFAULT_DRIVER));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    function __call($name, array $arguments)
    {
        return call_user_func_array([$this->driver, $name], $arguments);
    }
}