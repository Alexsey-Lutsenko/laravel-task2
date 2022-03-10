<?php

namespace App\Http\Controllers\Title;

use App\Http\Requests\Title\UpdateRequest;
use App\Http\Resources\Title\TitleResource;
use App\Models\Title;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Title $title)
    {
        $validated = $request->validated();

        $data = $this->service->update($title, $validated);

        return new TitleResource($data);
    }
}
