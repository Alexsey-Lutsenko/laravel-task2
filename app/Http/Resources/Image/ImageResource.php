<?php

namespace App\Http\Resources\Image;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'url' => $this->url,
            'size' => $this->size,
            'description' => $this->description,
            'title_id' => $this->title_id,
            'title' => $this->title->title,
            'name' => str_replace('images/', '', $this->path)
        ];
    }
}
