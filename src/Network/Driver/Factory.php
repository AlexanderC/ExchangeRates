<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 14:16
 */

namespace ExchangeRates\Network\Driver;

use Doctrine\Common\Inflector\Inflector;


/**
 * Class Factory
 * @package ExchangeRates\Network\Driver
 */
class Factory 
{
    /**
     * @param string $driverName
     * @return DriverInterface|AbstractDriver
     */
    public static function create($driverName)
    {
        $driverClass = $driverName;

        if(!class_exists($driverClass)) {
            $driverClass = sprintf(__NAMESPACE__ . "\\%sDriver", Inflector::classify($driverName));
        }

        return new $driverClass();
    }
}