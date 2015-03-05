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
        $endpoint = $this->vendor->getEndpoint($symbols);
        $data = $this->requestVendorData($endpoint);

        echo $data;
    }

    /**
     * make a request to the vendor's endpoint
     * @param  string $endpoint
     * @return string $response
     */
    private function requestVendorData($endpoint) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $endpoint );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        $response = curl_exec( $ch );
        curl_close( $ch );

        return $response;
    }
}