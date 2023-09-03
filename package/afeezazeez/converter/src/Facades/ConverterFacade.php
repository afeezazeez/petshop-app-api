<?php

namespace Afeezazeez\Converter\Facades;

use Illuminate\Support\Facades\Facade;

class ConverterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'convert';
    }
}
