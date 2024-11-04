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

        if ($categories === null) {
            trigger_error("Неуспешно извличане на категории. Моля, проверете параметрите.", E_USER_WARNING);
        }

        $totalCategories = CategoryService::total($column, $search);

        if ($totalCategories === null) {
            throw new Exception("Неуспешно извличане на общия брой категории.");
        }

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

    public static function Edit(): void
    {
        self::checkAuthentication();
        $metaTags = self::generateMetaTags("Редактиране на нова категорията");

        $secureToken = Generations::generateToken(Generations::generateFourDigitCode());
        $_SESSION["secure_token"] = $secureToken;

        $result = CategoryService::get("id", $_GET["id"]);

        if ($result["success"] === false) {
            Setup::redirect("/categories");
        }

        $category = $result["data"];

        Setup::View("categories/edit", [
            "user" => AuthService::isAuth() ?? null,
            "category" => $category,
            "metaTags" => $metaTags,
        ]);
    }
}
