<?php

namespace App\Services;

class MovieVerifyService
{

    /**
     * Array com os campos para validação de formulário de filme
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'name'=> ['required'],
            'description' => ['required'],
            'duration'=> ['required'],
            'tags'=> ['required'],
            'image'=> ['required'],
            'classification'=> ['required'],
        ];
    }
}