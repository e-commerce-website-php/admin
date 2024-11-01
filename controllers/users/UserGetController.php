<?php

class UserGetController
{
    public static function GetItems(): void
    {
        self::checkAuthentication();

        $metaTags = self::generateMetaTags();

        [$page, $limit, $column, $search] = self::getRequestParameters();

        $offset = ($page - 1) * $limit;
        $users = UserService::read($limit, $offset, $column, $search);
        
        $totalUsers = UserService::total($column, $search);

        Setup::View("users", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags,
            "users" => $users,
            "page" => $page,
            "limit" => $limit,
            "total" => $totalUsers,
        ]);
    }

    private static function checkAuthentication(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
        }
    }

    private static function generateMetaTags(): string
    {
        $generator = new MetaTagsGenerator();
        return $generator->generate([
            "title" => "Потребители",
        ]);
    }

    private static function getRequestParameters(): array
    {
        $page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
        $limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : SETTINGS["pagination_items_count"];
        $column = $_GET["column"] ?? null;
        $search = $_GET["search"] ?? null;

        return [$page, $limit, $column, $search];
    }
}