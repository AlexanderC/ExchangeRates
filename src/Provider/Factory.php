<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 14:12
 */

namespace ExchangeRates\Provider;

use Doctrine\Common\Inflector\Inflector;


/**
 * Class Factory
 * @package ExchangeRates\Provider
 */
class Factory 
{
    /**
     * @param string $providerName
     * @return ProviderInterface|AbstractProvider
     */
    public static function create($providerName)
    {
        $providerClass = $providerName;

        if(!class_exists($providerName)) {
            $providerClass = sprintf(__NAMESPACE__ . "\\%sProvider", Inflector::classify($providerName));
        }

        return new $providerClass();
    }
}