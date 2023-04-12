<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function getImage()
    {
        return $this->image->images->filename;
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
