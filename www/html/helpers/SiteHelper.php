<?php

class SiteHelper
{
    public static function getCookie(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function delCookie(string $key): ?string
    {
        return self::setCookie($key, '', (time() - 1));
    }

    public static function setCookie(string $key, string $value = '', int $expired = 0): bool
    {
        return setcookie($key, $value, $expired, '/');
    }
}