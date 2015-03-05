<?php namespace Libraries\FinanceApis;

class QuotesYahoo implements Quotes {

    private $endpoint = 'https://query.yahooapis.com/v1/public/yql';
    private $responseType = 'json';

    /**
     * make request to the vendor to get the data
     * @param  array $symbols
     * @return array $data
     */
    public function getEndpoint($symbols)
    {
        $symbols = $this->prepareSymbols($symbols);
        $params = $this->createEndpointParams($symbols);
        $endpoint = $this->endpoint . '?' . $params;
        
        return $endpoint;
    }

    /**
     * the yahoo api requires symbols to be in a SQL format
     * example: "YHOO","AAPL","GOOG","MSFT" 
     * @param  array $symbols
     * @return string $s
     */
    private function prepareSymbols($symbols)
    {
        $s = '';

        for ( $i = 0; $i < count( $symbols ); $i++ ) {
            $s .= '"' . strtoupper($symbols[$i]) . '",';
        }

        return trim($s, ',');
    }

    /**
     * create the paramaters for the vendor endpoint
     * @param  string $symbols
     * @return string $params
     */
    private function createEndpointParams($symbols) {

        $params = array(
            'q'         => 'select * from yahoo.finance.quotes where symbol in (' . $symbols . ')',
            'format'    => $this->responseType,
            'env'       => 'store://datatables.org/alltableswithkeys',
            'callback'  => '',
        );

        $p = '';
        foreach ($params as $key => $value) {
            $p .= $key . '=' . urlencode($value) . '&';
        }
        $p = trim($p, '&');

        return $p;
    }
}