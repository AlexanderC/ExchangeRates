<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:12
 */

namespace ExchangeRates\Provider;


use ExchangeRates\Collection;
use ExchangeRates\ExchangeRate;
use ExchangeRates\Provider\Exception\ParsingFailedException;

/**
 * Class PointMdProvider
 * @package ExchangeRates\Provider
 */
class PointMdProvider extends AbstractProvider
{
    const ENDPOINT_TPL = 'http://point.md/ru/curs/%s/';
    const LOCAL_CURRENCY = 'MDL';
    const COUNTRY = 'MDA';

    /**
     * @param \DateTime $date
     * @return Collection
     * @throws Exception\ParsingFailedException
     */
    public function parse(\DateTime $date)
    {
        $endpoint = sprintf(self::ENDPOINT_TPL, $date->format('Y-m-d'));

        $rawData = $this->networkClient->fetch($endpoint, [], ['X-Requested-With' => 'XMLHttpRequest']);

        $collection = [];

        foreach ($this->extractData($rawData) as list($type, $exchangeRate, $mainCurrency, $bank)) {
            if($exchangeRate > 0.0) {
                $collection[] = new ExchangeRate(
                    $type,
                    $exchangeRate,
                    $mainCurrency,
                    self::LOCAL_CURRENCY,
                    $date,
                    self::COUNTRY,
                    $bank
                );
            }
        }

        return new Collection($collection);
    }

    /**
     * @param string $rawData
     * @throws Exception\ParsingFailedException
     * @return \Generator
     */
    protected function extractData($rawData)
    {
        $data = @json_decode($rawData, true);

        if(!is_array($data)) {
            throw new ParsingFailedException("Invalid JSON string provided");
        }

        foreach($data['organizations'] as $organization) {
            $bank = $organization['name'];

            foreach($organization['rates'] as $mainCurrency => $rates) {
                yield [
                    ExchangeRate::BUY,
                    $rates['buy'],
                    $mainCurrency,
                    $bank
                ];

                yield [
                    ExchangeRate::SELL,
                    $rates['sell'],
                    $mainCurrency,
                    $bank
                ];
            }
        }

        $bank = $data['official']['name'];

        foreach($data['official']['rates'] as $mainCurrency => $rates) {
            foreach([ExchangeRate::BUY, ExchangeRate::SELL] as $type) {
                yield [
                    $type,
                    $rates['rate'],
                    $mainCurrency,
                    $bank
                ];
            }
        }
    }
}