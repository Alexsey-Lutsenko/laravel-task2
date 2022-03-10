<?php

namespace App\Http\Services\Image;

use App\Models\Image;
use App\Models\Title;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Service
{
    public function store($validated)
    {
        $title = Title::firstOrCreate(['title' => $validated['title']]);

        $images = $validated['images'];
        $newImages = array();

        foreach ($images as $image) {
            $name = md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

            $path = Storage::disk('public')->putFileAs('/images', $image, $name);
            $size = $image->getSize();

            $newImages[] = Image::create([
                'path' => $path,
                'url' => url('/storage/' . $path),
                'size' => $size,
                'description' => $validated['description'],
                'title_id' => $title->id
            ]);
        }
        return $newImages;
    }

    public function update($image, $validated)
    {
        $img = $validated['images'][0] ?? null;
        $title = Title::firstOrCreate(['title' => $validated['title']]);

        if($img) {
            $currentImg = $image->path;
            Storage::disk('public')->delete($currentImg);

            $name = md5(Carbon::now() . '_' . $img->getClientOriginalName()) . '.' . $img->getClientOriginalExtension();

            $path = Storage::disk('public')->putFileAs('/images', $img, $name);
            $size = $img->getSize();

            $image->update([
                'path' => $path,
                'url' => url('/storage/' . $path),
                'size' => $size
            ]);
        }

        $image->update([
            'description' => $validated['description'] ?? "",
            'title_id' => $title->id
        ]);

        return $image;
    }
}
