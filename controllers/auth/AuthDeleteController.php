<?php

class AuthDeleteController
{
    public static function Logout(): void
    {
        if (!empty($_GET['_method']) && $_GET['_method'] === 'DELETE') {
            AuthService::logout();
            Setup::redirect("/auth/login");
        }

        Setup::redirect("/");
    }
}