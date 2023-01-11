<?php

namespace App\Services;

use App\Models\Classification;

class ClassificationVerifyService
{
    public static function checkIfExistsAndReturnId($classification)
    {   
        $class = Classification::where('name', $classification)->get();

        if (!$class->isEmpty()) {
            
            return $class->implode('id');
        } 
        
        return Classification::createClassification($classification);
    }
}