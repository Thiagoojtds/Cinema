<?php

namespace App\Services;

use App\Models\Tag;

class TagsVerifyService
{
    public static function checkIfExistsAndReturnId($tags)
    {
        $tags_array = explode(" ", $tags);

        $tags = Tag::whereIn('name', $tags_array)->get();

        if (!$tags->isEmpty()) {
            
            return $tags->pluck('id');
        }

        return Tag::createTags($tags_array);
    }
}