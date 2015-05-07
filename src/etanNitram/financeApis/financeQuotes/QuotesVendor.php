<?php namespace EtanNitram\FinanceApis\FinanceQuotes;

use EtanNitram\FinanceApis\FinanceQuotes\Vendors\Quotes;

class QuotesVendor {

    private $vendor;

    /**
     * create vendor object
     * @param Quotes $vendor
     * @return  null
     */
    public function __construct(Quotes $vendor) {
        $this->vendor = $vendor;
    }

    /**
     * get stock quote information from the vendor
     * @param  array $symbols
     * @return array
     */
    public function getQuote($symbols) {

        // get the vendor's endpoint with request data        
        $data = $this->vendor->getVendorData($symbols);

        if ($this->vendor->requestError($data)) {
            return array('status' => 400, 'message' => 'the symbols you entered are not valid');
        }

        /**
         * because the quote data can be buried in other structures
         * we need to extract the relavant data, and put it into an array
         */
        $data = $this->vendor->getQuoteData($data);

        if (!isset($data[0]))
            $data = array($data);

        // now we can get our quote data from each set of quotes
        $quote = array();

        for ($i = 0; $i < count($data); $i++) {
            $quote[$i] = array(
                'name'              => $this->vendor->getName($data[$i]),
                'symbol'            => $this->vendor->getSymbol($data[$i]),
                'lastPrice'         => $this->vendor->getLastPrice($data[$i]),
                'lastPrice'         => $this->vendor->getLastPrice($data[$i]),
                'change'            => $this->vendor->getChange($data[$i]),
                'changePercent'     => $this->vendor->getChangePercent($data[$i]),
                'timeStamp'         => $this->vendor->getTimeStamp($data[$i]),
                'marketCap'         => $this->vendor->getMarketCap($data[$i]),
                'volume'            => $this->vendor->getVolume($data[$i]),
                'high'              => $this->vendor->getHigh($data[$i]),
                'low'               => $this->vendor->getLow($data[$i]),
                'open'              => $this->vendor->getOpen($data[$i]),
            );
        }

        return $quote;
    }
}
