<?php namespace Libraries\FinanceApis;

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

        return $data;
    }
}