<?php namespace EtanNitram\FinanceApis\FinanceQuotes\Vendors;

interface Quotes {

    /**
     * make request to the vendor to get the data
     * @param  array $symbols
     * @return array $data
     */
    public function getVendorData($symbols);

    /**
     * prepare a list of symbols to be consumed by the vendor
     * @param  array $symbols
     * @return string $s
     */
    public function prepareSymbols($symbols);

    /**
     * determine if the vendor threw an error
     * @param  string $data
     * @return boolean
     */
    public function requestError($data);

    /**
     * because the quote data can be buried in other structures
     * we need to extract the relavant data, and put it into an array
     * @param  arry $data
     * @return  arry $quotes
     */
    public function getQuoteData($data);

    /**
     * @param  array $data
     * @return string 
     */
    public function getName($data);

    /**
     * @param  array $data
     * @return string 
     */
    public function getSymbol($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getLastPrice($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getChange($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getChangePercent($data);

    /**
     * return unix timestamp in seconds
     * @param  array $data
     * @return integer
     */
    public function getTimeStamp($data);

    /**
     * @param  array $data
     * @return integer
     */
    public function getMarketCap($data);

    /**
     * @param  array $data
     * @return integer
     */
    public function getVolume($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getHigh($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getLow($data);

    /**
     * @param  array $data
     * @return float
     */
    public function getOpen($data);
}