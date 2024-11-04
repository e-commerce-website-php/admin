<?php

class ProductGetController extends BaseController
{
    public static function GetItems(): void
    {
        self::checkAuthentication();
        
        $metaTags = self::generateMetaTags("Продукти");
        [$page, $limit, $column, $search] = self::getRequestParameters();
        $offset = ($page - 1) * $limit;

        $products = ProductService::read($limit, $offset, $column, $search);
        $totalProducts = ProductService::total($column, $search);

        Setup::View("products/index", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags,
            "products" => $products,
            "page" => $page,
            "limit" => $limit,
            "total" => $totalProducts,
        ]);
    }

    public static function Create(): void
    {
        self::checkAuthentication();
        $metaTags = self::generateMetaTags("Създаване на нов продукт");

        $secureToken = Generations::generateToken(Generations::generateFourDigitCode());
        $_SESSION["secure_token"] = $secureToken;

        Setup::View("products/create", [
            "user" => AuthService::isAuth() ?? null,
            "metaTags" => $metaTags,
        ]);
    }

    public static function Edit(): void
    {
        self::checkAuthentication();
        $metaTags = self::generateMetaTags("Редактиране на продукта");

        $secureToken = Generations::generateToken(Generations::generateFourDigitCode());
        $_SESSION["secure_token"] = $secureToken;

        $result = ProductService::get("id", $_GET["id"]);

        if ($result["success"] === false) {
            Setup::redirect("/products");
        }

        Setup::View("products/edit", [
            "user" => AuthService::isAuth() ?? null,
            "product" => $result["data"],
            "metaTags" => $metaTags,
        ]);
    }
}