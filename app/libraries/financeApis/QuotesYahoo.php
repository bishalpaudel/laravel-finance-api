<?php namespace Libraries\FinanceApis;

class QuotesYahoo extends Vendor implements Quotes {

    private $endpoint = 'https://query.yahooapis.com/v1/public/yql';
    private $responseType = 'json';

    /**
     * make request to the vendor to get the data
     * @param  array $symbols
     * @return array $data
     */
    public function getVendorData($symbols)
    {
        $symbols = $this->prepareSymbols($symbols);
        $params = $this->createEndpointParams($symbols);
        $endpoint = $this->endpoint . '?' . $params;
        $data = $this->requestVendorData($endpoint);
        $data = ($this->responseType === 'json') ? json_decode($data, true) : $data;

        return $data;
    }

    /**
     * the yahoo api requires symbols to be in a SQL format
     * example: "YHOO","AAPL","GOOG","MSFT" 
     * @param  array $symbols
     * @return string $s
     */
    public function prepareSymbols($symbols)
    {
        $s = '';

        for ( $i = 0; $i < count( $symbols ); $i++ ) {
            $s .= '"' . strtoupper($symbols[$i]) . '",';
        }

        return trim($s, ',');
    }

    /**
     * determine if the vendor threw an error
     * @param  string $data
     * @return boolean
     */
    public function requestError($data)
    {
        if (isset($data['query']['results']['quote'])) {
            $quotes = $data['query']['results']['quote'];

            for ($i = 0; $i < count($quotes); $i++) {
                if (isset($quotes[$i]['ErrorIndicationreturnedforsymbolchangedinvalid'])
                    && $quotes[$i]['ErrorIndicationreturnedforsymbolchangedinvalid'] !== null) {
                    return true;
                }
            }
        } else {
            return true;
        }

        return false;
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