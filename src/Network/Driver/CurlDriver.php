<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:27
 */

namespace ExchangeRates\Network\Driver;


use ExchangeRates\Network\Exception\FetchException;

/**
 * Class CurlDriver
 * @package ExchangeRates\Network\Driver
 */
class CurlDriver extends AbstractDriver
{
    /**
     * @param string $endpoint
     * @param array $parameters
     * @param string $method
     * @return string
     * @throws \ExchangeRates\Network\Exception\FetchException
     */
    function fetch($endpoint, array $parameters, $method = self::GET)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method === self::POST) {
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        } else {
            curl_setopt($ch, CURLOPT_URL, $this->buildUrl($endpoint, $parameters));
        }

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new FetchException(curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}