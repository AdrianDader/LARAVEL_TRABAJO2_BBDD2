<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql'; // 👈 esto fuerza que use MySQL

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'visibility',
        'shared',
        'tags',
    ];

    protected $casts = [
        'shared' => 'boolean',
        'tags' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function getTagModelsAttribute()
    {
        $tagIds = $this->tags ?? [];

        return Tag::whereIn('_id', $tagIds)->get(); // Mongo query con los ObjectId
    }
}
