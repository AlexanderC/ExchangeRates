<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:10
 */

namespace ExchangeRates\Provider;


use ExchangeRates\Network\Helper\NetworkAwareTrait;

/**
 * Class AbstractProvider
 * @package ExchangeRates\Provider
 */
abstract class AbstractProvider implements ProviderInterface
{
    use NetworkAwareTrait;
}