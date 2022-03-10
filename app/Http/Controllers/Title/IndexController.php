<?php

namespace App\Http\Controllers\Title;

use App\Http\Controllers\Controller;
use App\Http\Resources\Title\TitleResource;
use App\Models\Title;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Title::all();

        return TitleResource::collection($data);
    }
}
