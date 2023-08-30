<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'album_type_id',
        'singer_name',
        'title',
        'slug',
        'genres',
        'songs_number',
        'image'
    ];

    public function albumType()
    {
        return $this->belongsTo(AlbumType::class);
    }


    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
