<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function clients() {
        return $this->hasMany(Client::class, 'status_id', 'id');
    }
}
