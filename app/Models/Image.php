<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = false;

    public function title() {
        return $this->belongsTo(Title::class, 'title_id', 'id');
    }
}
