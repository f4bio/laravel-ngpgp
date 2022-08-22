<?php

namespace F4bio\LaravelNgpgp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \F4bio\LaravelNgpgp\LaravelNgpgp
 */
class LaravelNgpgp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \F4bio\LaravelNgpgp\LaravelNgpgp::class;
    }
}
