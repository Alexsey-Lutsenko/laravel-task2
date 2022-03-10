<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function title() {
        return $this->belongsTo(Title::class, 'title_id', 'id');
    }
}
