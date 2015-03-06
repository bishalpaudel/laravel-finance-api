<?php namespace EtanNitram\FinanceApis;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Controller;
use Illuminate\Support\Facades\Input;
use EtanNitram\FinanceApis\FinanceQuotes\AssetQuotes;

class FinanceQuotes extends \Controller {

    private $apiConfig;

    public function __construct()
    {
        $this->apiConfig = Config::get('financeApi');
    }

    public function show()
    {
        /**
         * get a list of OR single stock symbols from the front end
         * symbols should be seperated by URL encoded commas
         */
        $symbols = Input::get('symbols');

        if ($symbols === null || $symbols === '')
            return array('status' => 400, 'message' => 'missing symbols paramater');

        $quotes = new AssetQuotes();

        // optional ability to set an API thirdparty vendor, like YAHOO, Markit, ect
        $vendor = Input::get('vendor');

        // set the vendor if an over ride was given
        if ($vendor !== null && ! $quotes->setVendor($vendor)) {
            return array('status' => 400, 'message' => 'invalid vendor');            
        }

        return $quotes->getInfo($symbols);
    }
}
