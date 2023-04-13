<?php

namespace App\Models;

use App\Models\Species;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// $articles = Article::factory()->hasImages->create();

class Article extends Model
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