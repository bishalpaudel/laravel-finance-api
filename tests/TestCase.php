<?php

class TestCase extends Orchestra\Testbench\TestCase {

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = include(__DIR__ . '/../src/config/financeApi.php');

        $app['config']->set('financeApi', $config);
        $app['config']->set('financeApis::financeApi', $config);
    }

    /**
     * Create a default test for this class
     */
    public function testHere()
    {
        $this->assertTrue(true);
    }
}