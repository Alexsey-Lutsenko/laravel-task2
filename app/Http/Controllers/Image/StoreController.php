<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\Image\StoreRequest;
use App\Http\Resources\Image\ImageResource;
use App\Mail\Client\TitlePublishedMail;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

//        $title_id = $data[0]->title_id;
//
//        $clients = Client::where('title_id', '=', $title_id)->get();
//
//        foreach ($clients as $client) {
//            Mail::to($client->mail)->send(new TitlePublishedMail());
//        }

        return ImageResource::collection($data);
    }
}
