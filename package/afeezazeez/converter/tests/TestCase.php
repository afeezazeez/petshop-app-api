<?php

namespace Afeezazeez\Converter\Tests;

use Afeezazeez\Converter\Providers\ConverterServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageProviders($app)
    {
        return [
            ConverterServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {

    }
}
