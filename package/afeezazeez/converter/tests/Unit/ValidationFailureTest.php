<?php

namespace Afeezazeez\Converter\Tests\Unit;

use Afeezazeez\Converter\Http\Controllers\ConverterController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Afeezazeez\Converter\Tests\TestCase;


class ValidationFailureTest extends TestCase
{
    /**
     * Test that api returns proper validation error if amount is not passed
     */
    public function test_validation_error(): void
    {
        $request = [
            'amount' => 'invalid',
            'currency' => 'USD',
        ];

        $response  = (new ConverterController())->convert(new Request($request));

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

    }

}
