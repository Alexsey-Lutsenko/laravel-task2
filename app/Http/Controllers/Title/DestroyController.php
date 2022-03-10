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
            return response(['data'=>['message' => "Запись $data связана с другой таблицей, удалить невозможно", 'error' => true]], 200);
        } else if ($isDelete === 1) {
            return response(['data'=>['message' => "$data не удалось удалить", 'error' => true]], 200);
        } else {
            return response(['data'=>['message' => "$data успешно удалено", 'error' => false]], 200);
        }
    }
}
