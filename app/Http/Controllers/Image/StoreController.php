<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\Image\StoreRequest;
use App\Http\Resources\Image\ImageResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

        return ImageResource::collection($data);
    }
}
