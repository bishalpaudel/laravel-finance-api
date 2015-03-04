<?php namespace Libraries\FinanceApis;

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

        if (in_array($vendor, array_keys($this->apiConfig['quotesVendors']))) {
            $this->vendor = $this->apiConfig['quotesVendors'][$vendor];
        } else {
            return false;
        }

        return true;
    }

    public function getInfo($symbols = '')
    {
        $quotesVendor = $this->quotesVendorFactory();
        $quotesVendor->getAssetQuote($symbols);
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