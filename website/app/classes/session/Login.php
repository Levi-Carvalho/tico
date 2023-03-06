<?php

namespace app\classes\session;

class Login {

    private static function init()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function logout()
    {
        self::init();

        unset($_SESSION['user']);

        header('location: index.php');
        exit;
    }

    public static function login($user)
    {
        self::init();

        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->nome,
            'username' => $user->username,
            'email' => $user->email,
        ];

        header('location: index.php');
        exit;
    }

    public static function is_logged()
    {
        self::init();
        return isset($_SESSION['user']['id']);
    }

    public static function isLogged()
    {
        return isset($_SESSION['user']['id']);
    }

    public static function require_login()
    {
        if(!self::is_logged()){
            header('location: login.php');
            exit;
        }
    }

    public static function require_logout()
    {
        if(self::is_logged()){
            header('location: index.php');
            exit;
        }
    }

}