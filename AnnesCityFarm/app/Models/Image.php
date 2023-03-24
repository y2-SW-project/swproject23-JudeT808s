<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function imageable()
    {
        return $this->morphTo();
    }
    // public function article()
    // {
    //     return $this->belongsTo(Article::class);
    // }

    // public function animal()
    // {
    //     return $this->belongsTo(Animal::class);
    // }
}
