<?php

class UserGetController
{
    public static function GetItems(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
        }

        $generator = new MetaTagsGenerator();
        $metaTags = $generator->generate([
            "title" => "Потребители",
        ]);

        Setup::View("users", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags
        ]);
    }
}
