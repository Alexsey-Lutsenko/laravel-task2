<?php

namespace App\Http\Controllers\Image;

use App\Http\Services\Image\Service;

class BaseController
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
