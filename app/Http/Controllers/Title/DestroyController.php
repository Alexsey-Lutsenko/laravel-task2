<?php

namespace App\Http\Controllers\Title;

use App\Models\Title;

class DestroyController extends BaseController
{
    public function __invoke(Title $title)
    {
        $data = $title->title;

        $isDelete = $this->service->destroy($title);

        if ($isDelete === 2) {
            return response(['message' => "Запись $data связана с другой таблицей, удалить невозможно"], 500);
        } else if ($isDelete === 1) {
            return response(['message' => "$data не удалось удалить"], 500);
        } else {
            return response(['message' => "$data успешно удалено"], 200);
        }
    }
}
