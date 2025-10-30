<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Superhero extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'real_name',
        'hero_name',
        'photo_url',
        'description',
    ];

    // Devuelve URL completa para la vista
    public function getPhotoUrlAttribute()
    {
        if (!$this->picture){
            return asset('storage/defaults/avatar.png');
        }
        return asset('storage/' . $this->picture);
    }
}