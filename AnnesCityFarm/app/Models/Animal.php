<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    
    public function image()
{
    return $this->belongsTo(Image::class);
}
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}