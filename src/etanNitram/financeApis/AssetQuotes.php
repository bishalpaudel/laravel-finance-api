<?php namespace EtanNitram\FinanceApis;

use Illuminate\Support\Facades\Config;

class AssetQuotes {

    private $vendor = '';
    private $apiConfig = array();

    public function __construct() {

        $this->apiConfig = Config::get('financeApi');

        $this->setDefaultVendor();
    }

    /**
     * for setting the vendor from the API route. If the setter fails
     * the controller should handle the error
     * @param string $vendor
     * @return boolean
     */
    public function setVendor($vendor = '')
    {
        $vendor = strtolower($vendor);
        if (in_array($vendor, array_keys($this->apiConfig['quotesVendors']))) {
            $this->vendor = $this->apiConfig['quotesVendors'][$vendor];
        } else {
            return false;
        }

        return true;
    }

    /**
     * get information about a given set of stock quotes
     * @param  string $symbols single or multiple symbols seperate by commas
     * @return array
     */
    public function getInfo($symbols = '')
    {
        // convert symbols into array format
        $symbols = $this->validateSymbols($symbols);
        // get the vendor object defined in $this->apiConfig to pass into QuotesVendor
        $vendor = $this->quotesVendorFactory();
        $quotes = new QuotesVendor($vendor);
        return $quotes->getQuote($symbols);
    }

    /**
     * symbols can be in the form of a single symbol,
     * or multiple symbols can be seperated by URL encode commas
     * All symbols must be alphanumeric
     * @param  string $symbols
     * @return array
     */
    private function validateSymbols($symbols = '')
    {
        $symbols = explode(',', urldecode($symbols));

        for ($i = 0; $i < count($symbols); $i++) {
            if (! ctype_alnum($symbols[$i]))
                throw new \Exception('Invalid ticker symbol format');
        }

        return $symbols;
    }

    /**
     * instantiate the vendor object to retrieve quotes
     * @return object $quotesVendor
     */
    private function quotesVendorFactory()
    {
        if (class_exists($this->vendor))
            return new $this->vendor();
        else
            throw new \Exception('Invalid quotesVendor defined in config file');
    }

    /**
     * set the vendor as described in the config and
     * defined by defaultVendor
     * @return null
     */
    private function setDefaultVendor()
    {

        $default = $this->apiConfig['defaultQuotesVendor'];

        if (in_array($default, array_keys($this->apiConfig['quotesVendors']))) {
            $this->vendor = $this->apiConfig['quotesVendors'][$default];

        } else {
            throw new \Exception('Invalid defaultQuotesVendor defined in config file');
        }
    }
}