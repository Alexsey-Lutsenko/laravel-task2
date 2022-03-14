<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Filters\ImageFilter;
use App\Http\Requests\Image\FilterRequest;
use App\Http\Resources\Image\ImageResource;
use App\Models\Image;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(ImageFilter::class, ['queryParams' => array_filter($data)]);

        $images = Image::filter($filter)->latest()->paginate(5);

        if(isset($data['random'])) {
            $images = Image::filter($filter)->inRandomOrder()->limit($data['random'])->get();
        }

        return ImageResource::collection($images);
    }
}
