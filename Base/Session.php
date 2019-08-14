<?php
/**
 * Created by PhpStorm.
 * User: usr
 * Date: 11.08.2019
 * Time: 16:15
 */

namespace Base;


class Session
{
    private $userId;
    private $userName;
    private static $_instance;

    private function __construct()
    {
        session_start();
    }

    private function __clone()
    {
    }

    public static function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

}