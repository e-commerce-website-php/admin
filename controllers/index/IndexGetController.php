<?php

class IndexGetController
{
    public static function Dashboard(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
        }

        $generator = new MetaTagsGenerator();
        $metaTags = $generator->generate([
            "title" => "Табло",
        ]);

        Setup::View("index/dashboard", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags
        ]);
    }
}
