<?php

namespace App\Models;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Species extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}