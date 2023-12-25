<?php

declare(strict_types=1);

namespace Support;

class Crypto
{
    public static function encrypt(string $data, string $key, string $method = 'aes-256-ecb'): string
    {
        $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA);
        $encrypted = strtoupper(implode('', unpack('H*', $encrypted)));
        return $encrypted;
    }

    public static function decrypt(string $data, string $key, string $method = 'aes-256-ecb'): string
    {
        $data = pack('H*', $data);
        $decrypted = openssl_decrypt($data, $method, $key, OPENSSL_RAW_DATA);
        return trim($decrypted);
    }
}
