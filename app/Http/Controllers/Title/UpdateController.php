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

        if ($data === 2) {
            return response(['data'=>['message' => "Запись $data связана с другой таблицей, изменить тему невозможно", 'error' => true]], 200);
        } else if ($data === 1) {
            return response(['data'=>['message' => "$data не удалось удалить", 'error' => true]], 200);
        } else {
            return response(['data'=>['error' => false]], 200);
        }
    }
}
