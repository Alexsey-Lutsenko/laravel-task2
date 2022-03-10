<?php

namespace App\Http\Controllers\Title;

use App\Http\Controllers\Controller;
use App\Http\Services\Title\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
