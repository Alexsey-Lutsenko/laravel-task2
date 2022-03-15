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

        $client->update($validated);

        return $client;
    }
}
