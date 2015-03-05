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

        /**
         * Markit does not excpet multiple symbols submited to its endpoint
         * therefore, we need to make multiple requests
         */
        $data = array();

        for ($i = 0; $i < count($symbols); $i++) {
            $data[$i] = $this->requestVendorData($endpoint, 'post', $symbols[$i]);
            $data[$i] = ($this->responseType === 'json') ? json_decode($data[$i], true) : $data[$i];
        }

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
     * @param  array $data
     * @return boolean
     */
    public function requestError($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            if (isset($data[$i]['Status']) && $data[$i]['Status'] === 'SUCCESS')
                return false;                    
        }
        
        return true;
    }

    /**
     * because the quote data can be buried in other structures
     * we need to extract the relavant data, and put it into an array
     * @param  arry $data
     * @return  arry $quotes
     */
    public function getQuoteData($data)
    {
        // the data is already in the proper array form
        return $data;
    }

    /**
     * @param  array $data
     * @return string 
     */
    public function getName($data)
    {
        return (isset($data['Name'])) ? $data['Name'] : '';
    }

    /**
     * @param  array $data
     * @return string 
     */
    public function getSymbol($data)
    {
        return (isset($data['Symbol'])) ? $data['Symbol'] : '';
    }

    /**
     * @param  array $data
     * @return float 
     */
    public function getLastPrice($data)
    {
        return (isset($data['LastPrice'])) ? (float) $data['LastPrice'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getChange($data)
    {
        return (isset($data['Change'])) ? (float) $data['Change'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getChangePercent($data)
    {
        return (isset($data['ChangePercent'])) ? (float) $data['ChangePercent'] : '';
    }

    /**
     * return unix timestamp in seconds
     * @param  array $data
     * @return integer
     */
    public function getTimeStamp($data)
    {
        return (isset($data['Timestamp'])) ? (int) strtotime($data['Timestamp']) : '';
    }

    /**
     * @param  array $data
     * @return integer
     */
    public function getMarketCap($data)
    {
        return (isset($data['MarketCap'])) ? (int) $data['MarketCap'] : '';
    }

    /**
     * @param  array $data
     * @return integer
     */
    public function getVolume($data)
    {
        return (isset($data['Volume'])) ? (int) $data['Volume'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getHigh($data) {
        return isset($data['High']) ? (float) $data['High'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getLow($data) {
        return isset($data['Low']) ? (float) $data['Low'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getOpen($data) {
        return isset($data['Open']) ? (float) $data['Open'] : '';
    }
}