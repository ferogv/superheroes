<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    protected $fillable = [
        'real_name',
        'hero_name',
        'photo_url',
        'description',
    ];
}