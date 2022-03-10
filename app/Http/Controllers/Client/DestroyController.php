<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;

class DestroyController extends Controller
{
    public function __invoke(Client $client)
    {
        $data = $client->fio;

        $isDelete = $client->delete();

        if (!$isDelete) {
            return response(["messages" => "$data не удалось удалить"], 500);
        }
        return response(["messages" => "$data удален успешно"], 200);
    }
}
