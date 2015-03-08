<?php

return array(

    /**
     * The default vendor if no vendor is set elsewhere in the application
     */
    'defaultQuotesVendor' => 'yahoo',

    /**
     * set the names of the vendors this application has access to
     */
    'quotesVendors' => array(
        'yahoo' => 'EtanNitram\FinanceApis\FinanceQuotes\Vendors\QuotesYahoo',
        'markit' => 'EtanNitram\FinanceApis\FinanceQuotes\Vendors\QuotesMarkit',
    ),
);