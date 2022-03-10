<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\Image\UpdateRequest;
use App\Http\Resources\Image\ImageResource;
use App\Models\Image;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Image $image)
    {
        $validated = $request->validated();

        $data = $this->service->update($image, $validated);

        return new ImageResource($data);
    }
}
