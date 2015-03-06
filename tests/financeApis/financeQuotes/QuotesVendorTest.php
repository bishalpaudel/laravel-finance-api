<?php

use Illuminate\Support\Facades\Config;
use EtanNitram\FinanceApis\QuotesVendor;

class QuotesVendorTest extends TestCase {

	public function testGetQuote()
	{
		// get the default vendor class defined in the config file
		$config = Config::get('financeApi');
		$default = $config['defaultQuotesVendor'];
		$vendor = $config['quotesVendors'][$default];

		$quotes = new QuotesVendor(new $vendor());
        $data = $quotes->getQuote(array('aapl', 'mcd'));

        // confirm the $data is of length 2 and first quote is for AAPL
		$this->assertTrue(count($data) === 2 && isset($data[0]['symbol']) && $data[0]['symbol'] === 'AAPL');
	}
}
