<?php

namespace App\Http\Controllers\Title;

use App\Http\Requests\Title\StoreRequest;
use App\Http\Resources\Title\TitleResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

        return new TitleResource($data);
    }
}
