<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Resources\Image\ImageResource;
use App\Models\Image;

class IndexController extends Controller
{
    public function __invoke()
    {
        $image = Image::latest()->paginate(5);

        return ImageResource::collection($image);
    }
}
