<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public static function createClassification($classification)
    {
        $class = Classification::create($classification);

        return $class->id;
    }
}
