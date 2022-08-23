<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public static function createTags(array $tags)
    {
        $tags_id = [];

        foreach ($tags as $tag) {

            $tag = Tag::create([
                'name' => $tag
            ]);

            array_push($tags_id, $tag->id);
        }

        return $tags_id;
    }
}
