<?php

namespace App\Http\Services\Title;

use App\Models\Title;

class Service
{
    public function store($validated)
    {
        return Title::create($validated);
    }

    public function update($title, $validated)
    {
        if(($title->clients->count() > 0 || $title->images->count() > 0) && ($title->title !== $validated['title'])) {
            return 2;
        }

        $title->update($validated);

        return $title;
    }

    public function destroy($title)
    {
        if($title->clients->count() > 0 || $title->images->count() > 0) {
            return 2;
        }

        $isDelete = $title->delete();

        if(!$isDelete) {
            return 1;
        }

        return 0;
    }
}
