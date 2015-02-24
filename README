ExchangeRates Library
=====================

##Main Goal##
Create a library that parses exchange rates using different providers.

##Installation##
 - Using [Composer](https://getcomposer.org) `composer install`

##Available Providers##
 - Moldova R. of
    - [CursMD](http://curs.md) (aka curs_md)

##Basic Usage##
```php
require 'vendor/autoload.php';

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
```

##TODO##
 - Unit tests
 - Add more providers
 
##License##
 - Apache v2.0