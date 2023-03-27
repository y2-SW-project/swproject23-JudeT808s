<?php

namespace App\Models;

use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
