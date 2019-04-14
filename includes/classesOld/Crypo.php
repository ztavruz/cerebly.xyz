<?php

/**
 * AES-ECB encryption with static const key
 */
class Crypo
{
    const KEY = "ADSERTYDADSERTYG";

    public static function encrypt($data)
    {
        return openssl_encrypt( $data, 'aes-128-ecb', self::KEY, OPENSSL_RAW_DATA);
    }

    public static function decrypt($data)
    {
        return openssl_decrypt( $data, 'aes-128-ecb', self::KEY, OPENSSL_RAW_DATA);
    }
}