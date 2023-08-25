<?php

namespace App\Helper;

class BatchHelper { 

    public static function validarPrefixo(string $hash) {
        $prefixo = substr($hash, 0, 4);
        
        if ("0000" === $prefixo) {
            return true;
        }

        return false;
    }

    public static function gerarHash(string $valor, string $key) {
        return md5($valor . $key);
    }

    public static function generateRandomString($length = 8) {
        $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $times = ceil($length/strlen($string));

        return substr(str_shuffle(str_repeat($string, $times)), 1, $length);
    }
}
