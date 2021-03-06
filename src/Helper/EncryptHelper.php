<?php

namespace App\Helper;

class EncryptHelper
{
    /**
     * Generate random string
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandomString($length = 32): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Encrypt string param.
     *
     * @param string|null $string
     *
     * @return string
     */
    public static function encryptKey(string $string = null): string
    {
        if (is_null($string)) {
            $string = static::generateRandomString();
        }
        return crypt($string, $_ENV['API_KEY_SALT']);
    }
}
