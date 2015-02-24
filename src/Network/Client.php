<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:28
 */

namespace ExchangeRates\Network;

use Doctrine\Common\Inflector\Inflector;
use ExchangeRates\Network\Driver\DriverInterface;

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
        $driverName = $driverName ?: self::DEFAULT_DRIVER;
        $driverClass = sprintf(__NAMESPACE__ . "\\Driver\\%sDriver", Inflector::classify($driverName));

        return new static(new $driverClass());
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