<?php namespace Libraries\FinanceApis;

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
}