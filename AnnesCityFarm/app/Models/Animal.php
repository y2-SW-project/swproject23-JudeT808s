<?php

namespace App\Models;

use App\Models\Species;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    protected $fillable = ['name', 'age', 'description', 'species_id'];
    use HasFactory;

    public function getImage()
    {
        return $this->image->images->filename;
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}
