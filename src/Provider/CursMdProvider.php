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
use ExchangeRates\Network\Driver\AbstractDriver;
use ExchangeRates\Provider\Exception\ParsingFailedException;

/**
 * Class CursMdProvider
 * @package ExchangeRates\Provider
 */
class CursMdProvider extends AbstractProvider
{
    const ENDPOINT = 'http://www.curs.md/en/ajax/block?block_name=bank_valute_table';
    const DATE_PARAMETER = 'CotDate';
    const LOCAL_CURRENCY = 'MDL';
    const COUNTRY = 'MDA';

    /**
     * @param \DateTime $date
     * @return Collection
     * @throws Exception\ParsingFailedException
     */
    public function parse(\DateTime $date)
    {
        $dateString = $date->format('d.m.Y');
        $parameters = [self::DATE_PARAMETER => $dateString];

        $rawData = $this->networkClient->fetch(self::ENDPOINT, $parameters, AbstractDriver::POST);

        $collection = [];

        foreach ($this->extractData($rawData) as list($type, $exchangeRate, $mainCurrency, $bank)) {
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

        return new Collection($collection);
    }

    /**
     * @param string $rawData
     * @throws Exception\ParsingFailedException
     * @return \Generator
     */
    protected function extractData($rawData)
    {
        $content = new \SimpleXMLElement($rawData);

        $table = @$content->xpath("//table[@id='tabelBankValute']")[0];

        if (!is_object($table)) {
            throw new ParsingFailedException("Unable to find currencies table");
        }

        $currencies = [];

        foreach ($table->xpath("thead/tr[position()=1]/td") as $currencyNode) {
            $currencies[] = (string)$currencyNode;
        }

        $currenciesCount = count($currencies);
        $currencyKey = 0;

        foreach ($table->xpath("tbody/tr") as $ratesRow) {
            $bank = (string)$ratesRow->xpath("td[@class='bank_name']/a")[0];

            foreach ($ratesRow->xpath("td[position() mod 2 = 0]") as $buyRate) {
                yield [
                    ExchangeRate::BUY,
                    abs((float)(string)$buyRate),
                    $currencies[$currencyKey++],
                    $bank
                ];

                if ($currencyKey >= $currenciesCount) {
                    $currencyKey = 0;
                }
            }

            $currencyKey = 0;

            foreach ($ratesRow->xpath("td[position() > 1 and position() mod 2 = 1]") as $sellRate) {
                yield [
                    ExchangeRate::SELL,
                    abs((float)(string)$sellRate),
                    $currencies[$currencyKey++],
                    $bank
                ];

                if ($currencyKey >= $currenciesCount) {
                    $currencyKey = 0;
                }
            }
        }
    }
}