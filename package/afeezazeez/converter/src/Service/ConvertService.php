<?php

namespace Afeezazeez\Converter\Service;


use Afeezazeez\Converter\Exceptions\ClientErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ConvertService
{
    /**
     * check price of a particular product or the total cart amount in preferred currency
     */
    public function convert(int $amount, string $currency): float
    {
        $result = $this->fetchCurrencyRates();

        $matchingCurrencies = array_values(array_filter($result, function ($entry) use ($currency) {
            return $entry['@attributes']['currency'] === $currency;
        }));

        if (count($matchingCurrencies) > 0) {
            $rate = floatval($matchingCurrencies[0]['@attributes']['rate']);
            return round($amount * $rate,2);
        }
        throw new ClientErrorException('Currency not found');
    }

    /**
     * Fetch currency rates from remote api
     *
     */
    public function fetchCurrencyRates(): mixed
    {
        $response = Http::get(config('convert.ecb_api_url'));

        if ($response->failed()) {
            throw new ClientErrorException('Request failed. Please check the ecb url',
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $xml = simplexml_load_string($response->body());

        $result = json_decode(json_encode($xml), true);

        return $result['Cube']['Cube']['Cube'];

    }


}
