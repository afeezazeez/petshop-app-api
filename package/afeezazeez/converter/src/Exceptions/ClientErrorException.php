<?php

namespace Afeezazeez\Converter\Exceptions;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClientErrorException extends HttpException
{
    public function __construct($message = 'Client Error', $code = 400,
                                \Throwable $previous = null, array $headers = [])
    {
        parent::__construct($code, $message, $previous, $headers);
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'success' => 0,
            'data' => [],
            'error' => $this->getMessage(),
            'errors' => [],
            'trace' => []
        ], $this->getStatusCode());
    }
}
