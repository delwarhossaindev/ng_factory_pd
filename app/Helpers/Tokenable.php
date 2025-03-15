<?php 

namespace App\Helpers;

use Illuminate\Support\Str;

Trait Tokenable 
{   
    /**
     * Summary of saveToken
     * @return self
     */
    public function saveToken() : self
    {   
        $token = Str::random(60);

        $this->api_token = $token;
        $this->save();

        return $this;
    }
}