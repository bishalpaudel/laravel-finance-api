<?php

use Illuminate\Support\Facades\Config;
use EtanNitram\FinanceApis\FinanceQuotes\AssetQuotes;

class AssetQuotesTest extends TestCase {

	public function testGetInfo()
	{
		$quotes = new AssetQuotes();
		$quotes->setVendor('yahoo');
		// stock symbols must seperated by url encode commas
		$data = $quotes->getInfo('aapl%2Cmcd');

        // confirm the $data is of length 2 and first quote is for AAPL
		$this->assertTrue(count($data) === 2 && isset($data[0]['symbol']) && $data[0]['symbol'] === 'AAPL');
	}
}
