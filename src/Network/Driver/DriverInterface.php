<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 11:59
 */

namespace ExchangeRates\Network\Driver;


/**
 * Interface DriverInterface
 * @package ExchangeRates\Network\Driver
 */
interface DriverInterface
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';

    /**
     * @param string $endpoint
     * @param array $parameters
     * @param array $headers
     * @param string $method
     * @return string
     * @throws \ExchangeRates\Network\Exception\FetchException
     */
    function fetch($endpoint, array $parameters = [], array $headers = [], $method = self::GET);
}