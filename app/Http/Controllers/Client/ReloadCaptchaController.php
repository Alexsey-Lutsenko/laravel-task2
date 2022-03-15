<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Resources\Client\ClientResource;

class ReloadCaptchaController extends BaseController
{
    public function __invoke()
    {
         return response(["data"=>["captcha_path"=>captcha_src()]]);
    }
}
