<?php

namespace App\Http\Controllers\Client;

use App\Http\Services\Client\Service;

class BaseController
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
