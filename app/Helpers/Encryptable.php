<?php

namespace App\Helpers;

class Encryptable
{   
    /**
     * Summary of encryptData
     * @param mixed $data
     * @return array
     */
    public function encryptData($data = [])
    {   
        $encrypted_data = openssl_encrypt(
            json_encode($data),
            'AES-256-CBC',
            env('ENCRYPTION_KEY'),
            0,
            env('ENCRYPTION_IV')
        );
    
        return [
            'data' => $data ? $encrypted_data : NULL
        ];
    }
}