<?php namespace EtanNitram\FinanceApis\FinanceQuotes\Vendors;

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
     * because the quote data can be buried in other structures
     * we need to extract the relavant data, and put it into an array
     * @param  arry $data
     * @return  arry $quotes
     */
    public function getQuoteData($data)
    {
        if (isset($data['query']['results']['quote']))
            return $data['query']['results']['quote'];
    }

    /**
     * @param  array $data
     * @return string 
     */
    public function getName($data)
    {
        return isset($data['Name']) ? $data['Name'] : '';
    }

    /**
     * @param  array $data
     * @return string 
     */
    public function getSymbol($data)
    {
        return isset($data['Symbol']) ? $data['Symbol'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getLastPrice($data)
    {
        return isset($data['LastTradePriceOnly']) ? (float) $data['LastTradePriceOnly'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getChange($data)
    {
        return isset($data['Change']) ? (float) $data['Change'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getChangePercent($data)
    {
        $percent = isset($data['Change_PercentChange']) ? (float) $data['Change_PercentChange'] : '';
        $percent = explode(' - ', $percent);
        $percent = isset($percent[1]) ? trim($percent[1], '%') : 0;
        return (float) $percent;
    }

    /**
     * return unix timestamp in seconds
     * @param  array $data
     * @return integer
     */
    public function getTimeStamp($data)
    {
        return (isset($data['LastTradeDate']) && isset($data['LastTradeTime']))
            ? (int) strtotime($data['LastTradeDate'] . ' ' . $data['LastTradeTime'] )
            : '';
    }

    /**
     * @param  array $data
     * @return string
     */
    public function getMarketCap($data)
    {
        return isset($data['MarketCapitalization']) ? (string) $data['MarketCapitalization'] : '';
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
        return isset($data['DaysHigh']) ? (float) $data['DaysHigh'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getLow($data) {
        return isset($data['DaysLow']) ? (float) $data['DaysLow'] : '';
    }

    /**
     * @param  array $data
     * @return float
     */
    public function getOpen($data) {
        return isset($data['Open']) ? (float) $data['Open'] : '';
    }

}