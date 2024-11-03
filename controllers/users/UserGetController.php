<?php

class UserGetController extends BaseController
{
    public static function GetItems(): void
    {
        self::checkAuthentication();

        $metaTags = self::generateMetaTags("Потребители");

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
}