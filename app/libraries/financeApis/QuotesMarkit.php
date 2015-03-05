<?php namespace Libraries\FinanceApis;

class QuotesMarkit extends Vendor implements Quotes {

    private $endpoint = 'http://dev.markitondemand.com/Api/v2/Quote/';
    private $responseType = 'json';
    
    /**
     * make request to the vendor to get the data
     * @param  array $symbols
     * @return array $data
     */
    public function getVendorData($symbols)
    {
        $symbols = $this->prepareSymbols($symbols);
        $endpoint = $this->endpoint . $this->responseType;
        $data = $this->requestVendorData($endpoint, 'post', $symbols);
        $data = ($this->responseType === 'json') ? json_decode($data, true) : $data;

        return $data;
    }

    /**
     * the market api excepts Post data in the format symbol=AAPL
     * example: "YHOO","AAPL","GOOG","MSFT" 
     * @param  array $symbols
     * @return string $s
     */
    public function prepareSymbols($symbols)
    {
        $s = array();

        for ( $i = 0; $i < count( $symbols ); $i++ ) {
            $s[$i] = array(
                'symbol' => strtoupper($symbols[$i]),
            );
        }

        return $s;
    }

    /**
     * determine if the vendor threw an error
     * @param  string $data
     * @return boolean
     */
    public function requestError($data)
    {
        if (isset($data['status']) && $data['status'] === 'SUCCESS')
            return false;
        
        return true;
    }
}