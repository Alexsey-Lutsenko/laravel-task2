<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'fio' => $this->fio,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
            'mail' => $this->mail,
            'title_id' => $this->title_id,
            'title' => $this->title->title,
        ];
    }
}
