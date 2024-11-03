<?php

class CategoryGetController extends BaseController
{
    public static function GetItems(): void
    {
        self::checkAuthentication();
        
        $metaTags = self::generateMetaTags("Категории");
        [$page, $limit, $column, $search] = self::getRequestParameters();
        $offset = ($page - 1) * $limit;

        $categories = CategoryService::read($limit, $offset, $column, $search);
        $totalCategories = CategoryService::total($column, $search);

        Setup::View("categories/index", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags,
            "categories" => $categories,
            "page" => $page,
            "limit" => $limit,
            "total" => $totalCategories,
        ]);
    }

    public static function Create(): void
    {
        self::checkAuthentication();
        $metaTags = self::generateMetaTags("Създаване на нова категория");

        $secureToken = Generations::generateToken(Generations::generateFourDigitCode());
        $_SESSION["secure_token"] = $secureToken;

        Setup::View("categories/create", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags,
        ]);
    }
}
