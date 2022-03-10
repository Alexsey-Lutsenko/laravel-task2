<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\Image\UpdateRequest;
use App\Http\Resources\Image\ImageResource;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class DestroyController extends BaseController
{
    public function __invoke(Image $image)
    {
        $data = $image->path;

        $currentImg = $image->path;
        Storage::disk('public')->delete($currentImg);

        $isDelete = $image->delete();

        if (!$isDelete) {
            return response(["messages" => "$data не удалось удалить"], 500);
        }
        return response(["messages" => "$data удален успешно"], 200);
    }
}
