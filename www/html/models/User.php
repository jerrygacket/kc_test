<?php

class User
{
    public string $username;
    public string $password_hash;

    public const SESSION_DURATION = 3600;

    public function __construct($config)
    {
        $this->username = $config['username'];
        $this->password_hash = $config['password_hash'];
    }

    public static function getTable(): string
    {
        return 'api_users';
    }

    public static function isGuest(): bool
    {
        return empty(SiteHelper::getCookie('session_id'));
    }

    public static function finByUserName($username): ?User
    {
        $db = DBWorker::getInstance();

        $user = $db->Select(User::getTable(), null, ['username' => $username]);

        if (!empty($user)) {
            return new self($user);
        }

        return null;
    }

    public function login(string $password, $remember = false): bool
    {
        if ($this->checkPassword($password)) {
            SiteHelper::setCookie('session_id', $this->username, $remember ? (time() + self::SESSION_DURATION) : 0);

            return true;
        }

        return false;
    }

    public static function logout()
    {
        return SiteHelper::delCookie('session_id');
    }

    public static function getPasswordHash(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }
}