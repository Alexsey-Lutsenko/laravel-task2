<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Client::orderBy('status_id', 'asc')->orderBy('id', 'desc')->get();

        return ClientResource::collection($data);
    }
}
