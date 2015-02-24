<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alexanderc@pycoding.biz>
 * Date: 2/24/15
 * Time: 12:45
 */

require __DIR__ . '/../vendor/autoload.php';

use ExchangeRates\Client;

$client = Client::create('curs_md');

foreach($client->parse(new \DateTime()) as $rate) {
    echo sprintf(
        "%s (%s), %s: %s=%.2f%s\n",
        $rate->getCountry(),
        $rate->getBank(),
        $rate->getHumanizedType(),
        $rate->getMainCurrency(),
        $rate->getExchangeRate(),
        $rate->getLocalCurrency()
    );
}