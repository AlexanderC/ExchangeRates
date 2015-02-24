<?php
/**
 * Created by PhpStorm.
 * User: AlexanderC <alex@mitocgroup.com>
 * Date: 12/17/14
 * Time: 14:19
 */

namespace ExchangeRates;


/**
 * Class ExchangeRate
 * @package ExchangeRates
 */
class ExchangeRate
{
    const BUY = 0x001;
    const SELL = 0x002;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var float
     */
    protected $exchangeRate;

    /**
     * @var string
     */
    protected $mainCurrency;

    /**
     * @var string
     */
    protected $localCurrency;

    /**
     * @var \DateTime
     */
    protected $relatedTo;

    /**
     * @var string
     */
    protected $bank;

    /**
     * @var string
     */
    protected $country;

    /**
     * @param int $type
     * @param float $exchangeRate
     * @param string $mainCurrency ISO3166-1 currency abbreviation format
     * @param string $localCurrency ISO3166-1 currency abbreviation format
     * @param \DateTime $relatedTo
     * @param string $country ISO3166-1 alpha3 country abbreviation format
     * @param string $bank
     */
    function __construct(
        $type,
        $exchangeRate,
        $mainCurrency,
        $localCurrency,
        \DateTime $relatedTo,
        $country,
        $bank = null
    ) {
        $this->type = $type;
        $this->exchangeRate = $exchangeRate;
        $this->mainCurrency = $mainCurrency;
        $this->localCurrency = $localCurrency;
        $this->relatedTo = $relatedTo;
        $this->country = $country;
        $this->bank = $bank;
    }

    /**
     * ISO3166-1 alpha3 country abbreviation format
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHumanizedType()
    {
        switch($this->type) {
            case self::BUY:
                return 'buy';
                break;
            case self::SELL:
                return 'sell';
                break;
            default: throw new \RuntimeException(sprintf("Unknown type %d provided", $this->type));
        }
    }

    /**
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @return float
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @return \DateTime
     */
    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    /**
     * ISO3166-1 currency abbreviation format
     *
     * @return string
     */
    public function getLocalCurrency()
    {
        return $this->localCurrency;
    }

    /**
     * ISO3166-1 currency abbreviation format
     *
     * @return string
     */
    public function getMainCurrency()
    {
        return $this->mainCurrency;
    }
}