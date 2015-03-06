<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

}
