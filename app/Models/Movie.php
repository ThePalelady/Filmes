<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'synopsis',
        'year',
        'cover_image',
        'trailer_link',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}