<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function images() {
        return $this->hasMany(Image::class, 'title_id', 'id');
    }

    public function clients() {
        return $this->hasMany(Client::class, 'title_id', 'id');
    }
}
