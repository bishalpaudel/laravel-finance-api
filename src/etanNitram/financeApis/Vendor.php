<?php namespace EtanNitram\FinanceApis;

class Vendor {

    /**
     * make a request to the vendor's endpoint
     * @param  string $endpoint
     * @param  string $request 
     * @param  array  $postData
     * @return string
     */
    public function requestVendorData($endpoint, $request = 'get', $postData = array())
    {
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $endpoint );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

        if ($request === 'post') {
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->parsePostData($postData) );
        }

        $response = curl_exec( $ch );
        curl_close( $ch );

        return $response;
    }

    /**
     * convert arrays to key value pairs for post data
     * @param  array $data
     * @return string 
     */
    private function parsePostData($data)
    {
        $d = '';
        foreach ($data as $k => $v) {
            
            if (is_string($k)) {
                $d .= $k . '=' . $v . '&';
            } else {
                foreach ($data[$k] as $key => $value) {
                    $d .= $key . '=' . $value . '&';
                }                
            }

        }

        return trim($d, '&');
    }
}