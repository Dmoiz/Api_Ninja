<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ninja extends Model
{
    use HasFactory;
    public function misions() {
        return $this->belongsToMany(Mision::class);
    }
}
