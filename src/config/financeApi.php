<?php

return array(

    /**
     * The default vendor if no vendor is set elsewhere in the application
     */
    'defaultQuotesVendor' => 'markit',

    /**
     * set the names of the vendors this application has access to
     */
    'quotesVendors' => array(
        'yahoo' => 'Libraries\FinanceApis\Vendors\QuotesYahoo',
        'markit' => 'Libraries\FinanceApis\Vendors\QuotesMarkit',
    ),
);