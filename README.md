ExchangeRates Library
=====================
Library that parses exchange rates of different countries using different providers

##Reuirements##
See `composer.json`

##Installation##
 - Install [Composer](https://getcomposer.org)
 - Add in your `composer.json` under require section: `"alexanderc/exchange-rates": "dev-master"`
 - Run `composer.phar install` or `composer.phar update`

##Available Providers##
 - Moldova R. of
    - [CursMD](http://curs.md) (aka curs_md)
    - [PointMD](http://point.md) (aka point_md)

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

Check [https://github.com/AlexanderC/ExchangeRates/blob/master/tests/basic.php](tests/basic.php) for more examples

##TODO##
 - Unit tests
 - Add more providers
 
##License##
 - Apache v2.0
 
##Sponsors##
 - [PyCoding](http://www.pycoding.biz)

 