<?php

namespace Afeezazeez\Converter\Tests\Unit;

use Afeezazeez\Converter\Http\Controllers\ConverterController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Afeezazeez\Converter\Tests\TestCase;


class SuccessfulConversionTest extends TestCase
{

    protected ConverterController $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new ConverterController();
    }

    /**
     * Test successful conversion when amount and valid currency are passed
     */
    public function  test_successful_conversion(): void
    {
        Http::fake([
            config('convert.ecb_api_url') => Http::response($this->getSampleApiResponse(), Response::HTTP_OK),
        ]);

        $request = [
            'amount' => 100,
            'currency' => 'JPY',
        ];

        $response = $this->controller->convert(new Request($request));

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertJson(json_encode($responseData));


    }

    private function getSampleApiResponse(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
        <Cube>
            <Cube>
                <Cube time="2023-08-28">
                    <Cube currency="USD" rate="1.0808" />
                    <Cube currency="JPY" rate="158.35" />
                    <Cube currency="BGN" rate="1.9558" />
                    <Cube currency="CZK" rate="24.138" />
                </Cube>
            </Cube>
        </Cube>';
    }


}
