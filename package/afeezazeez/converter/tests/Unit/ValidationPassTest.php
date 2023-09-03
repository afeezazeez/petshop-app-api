<?php

namespace Afeezazeez\Converter\Tests\Unit;

use Afeezazeez\Converter\Http\Controllers\ConverterController;
use Illuminate\Http\Response;
use Afeezazeez\Converter\Tests\TestCase;
use Illuminate\Http\Request;

class ValidationPassTest extends TestCase
{

    /**
     * Test that validation is passed when valid amount is passed
     */
    public function test_validation_error(): void
    {
        $request = [
            'amount' => 100,
            'currency' => 'USD',
        ];

        $response  = (new ConverterController())->convert(new Request($request));

        $this->assertEquals(Response::HTTP_OK,$response->getStatusCode());

    }

}
