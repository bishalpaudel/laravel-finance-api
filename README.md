## Laravel Finance APIs

Make requests from your App to finace API's like Yahoo and Markit

[![Build Status](https://travis-ci.org/etan-nitram/laravel-finance-api.svg?branch=master)](https://travis-ci.org/etan-nitram/laravel-finance-api)

**Important**
- This package is intended for use with free Finance rest APIs
- This package does not offer oAuth authentication for APIs that require Auth

### Composer

To install **Laravel Finance APIs** as a composer package, add the below line to your `require` block in your `composer.json` file;

```json
"require": {
    "etannitram/laravel-finance-apis": "dev-master"
}
```

And then run `composer update` in your Laravel root project folder.  After Composer has updated, register the Package Service Provider in `app/config/app.php` in the `providers` array:

```php
'providers' => array(
    'EtanNitram\FinanceApis\FinanceApisServiceProvider',
)
```
### Documentation

To make a request to a finance API, add your desired endpoint to your `routes.php` folder and point your route to the `EtanNitram\FinanceApis\FinanceQuotes@show` class and method.

```php
Route::get( 'finance-api', array( 'uses' => 'EtanNitram\FinanceApis\FinanceQuotes@show' ), function( $response ){
    return $response;
});
```

You can now make a request to your site `example.com/finance-api?symbols=aapl,ibm` to receive stock quote information about Apple Inc and IBM.  Your response should look like this;

- You can add multiple symbols to the `symbols` parameter
- Symbols must be separated by URL encoded commas `%2C`

```json
[{"name":"Apple Inc","symbol":"AAPL","lastPrice":126.6,"change":0.19,"changePercent":0.1503045645123,"timeStamp":1425675540,"marketCap":737413096800,"volume":8165333,"high":129.37,"low":126.26,"open":128.42},{"name":"International Business Machines Corp","symbol":"IBM","lastPrice":158.48,"change":-0.02000000000001,"changePercent":-0.012618296529975,"timeStamp":1425675540,"marketCap":156645435520,"volume":315500,"high":161.43,"low":158.08,"open":160.2}]
```

**Change Finance Vendor**

The default finance API is set to [Yahoo's YQL Console](https://developer.yahoo.com/yql/console/), endpoint `https://query.yahooapis.com/v1/public/yql`. This package is also configured to use the [Markit On Demand Quote Api](http://dev.markitondemand.com/), endpoint `http://dev.markitondemand.com/Api/v2/Quote/`.

To change from Yahoo to the Markit API, simply add `vendor=markit` to your Laravel request `example.com/finance-api?symbols=aapl,ibm&vendor=markit`.

**Use your own Controller/Models**

To bypass the Controller `EtanNitram\FinanceApis\FinanceQuotes@show` class and method, directly use the class `EtanNitram\FinanceApis\FinanceQuotes\AssetQuotes`, and pass your comma separated symbols into the method `$quotes->getInfo($symbols)`.

```php
use Illuminate\Support\Facades\Input;
use EtanNitram\FinanceApis\FinanceQuotes\AssetQuotes;

class YourClass {
    
    public function getQuotes()
    {
        $symbols = Input::get('symbols');
        $vendor = Input::get('vendor');

        $quotes = new AssetQuotes();

        if ($vendor !== null)
            $quotes->setVendor($vendor);

        return $quotes->getInfo($symbols);
    }
}
```