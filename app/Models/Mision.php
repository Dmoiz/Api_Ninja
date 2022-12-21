<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mision extends Model
{
    use HasFactory;
    public function ninjas() {
        return $this->belongsToMany(Ninja::class);
    }
}
