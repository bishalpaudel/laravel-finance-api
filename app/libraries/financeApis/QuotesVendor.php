<?php namespace Libraries\FinanceApis;

class QuotesVendor {

    private $vendor;

    public function __construct(Quotes $vendor) {
        $this->vendor = $vendor;
    }

    public function getQuote($symbols) {
        $this->vendor->getQuote($symbols);
    }
}