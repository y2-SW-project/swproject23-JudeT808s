<?php

namespace App\Models;

use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Day extends Model
{
    use HasFactory;

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class)->withTimestamps();
    }
}
