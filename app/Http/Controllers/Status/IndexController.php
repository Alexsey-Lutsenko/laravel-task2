<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Http\Resources\Status\StatusResource;
use App\Models\Status;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Status::all();

        return StatusResource::collection($data);
    }
}
