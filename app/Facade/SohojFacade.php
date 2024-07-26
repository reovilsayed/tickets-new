<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class SohojFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sohoj';
    }
}
