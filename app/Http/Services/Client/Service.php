<?php

namespace App\Http\Services\Client;

use App\Models\Client;
use App\Models\Title;

class Service
{
    public function store($validated)
    {
        if(isset($validated['title'])) {
            $title = Title::firstOrCreate(['title' => $validated['title']]);
            unset($validated['title']);
            $validated['title_id'] = $title->id;
        }

        return Client::create($validated);
    }

    public function update($client, $validated)
    {
        if(isset($validated['title'])) {
            $title = Title::firstOrCreate(['title' => $validated['title']]);
            $validated['title_id'] = $title->id;
        }

        unset($validated['title']);

        if(isset($validated['status_id']) && $validated['status_id'] == 3) {
            $pendingClient = Client::orderBy('id', 'asc')
                ->where('fio', 'like', $client->fio)
                ->where('phone_number', 'like', $client->phone_number)
                ->where('status_id', '=', 1)
                ->first();
            $pendingClient->update(['status_id' => 2]);
        }

        $client->update($validated);

        return $client;
    }
}
