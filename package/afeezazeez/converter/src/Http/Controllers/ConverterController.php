<?php

namespace Afeezazeez\Converter\Http\Controllers;

use Afeezazeez\Converter\Service\ConvertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConverterController extends Controller
{
    /**
     * check price of a particular product or the total cart amount in preferred currency
     */
    public function convert(Request $request): JsonResponse
    {
        $rules = [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['string'],
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'data' => [],
                'error' => 'Failed validation',
                'errors' => $validator->errors(),
                'trace' => [],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $amount = $request->amount;

        $currency = strtoupper($request->currency) ?? config('convert.default_currency');

        $amountConverted = (new ConvertService())->convert($amount,$currency);

        return response()->json([
            'success' =>1,
            'data' =>[
                'exchange_rate' => $amountConverted,
            ],
            'error' =>null,
            'errors '=>[],
            'trace' =>[],
        ], Response::HTTP_OK);

    }
}
