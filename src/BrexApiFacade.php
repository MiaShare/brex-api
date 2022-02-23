<?php

namespace MiaShare\BrexApi;

use Illuminate\Support\Facades\Facade;

class MozLocalFacade extends Facade 
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
	{
		return 'brex-api';
	}
}