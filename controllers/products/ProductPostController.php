<?php

class ProductPostController extends BaseController
{
    private static array $createFields = ["name", "slug", "description", "short_description", "price", "tax", "sale_price", "stock_quantity", "show_stock", "sku", "additional_images", "image", "status", "seo_title", "seo_description", "seo_keywords"];
    private static array $editFields = ["name", "slug", "description", "short_description", "price", "tax", "sale_price", "stock_quantity", "show_stock", "sku", "image", "status", "seo_title", "seo_description", "seo_keywords"];

    private static function checkAccess(callable $function): void
    {
        if (
            empty($_POST["secure_token"])
            || empty($_SESSION["secure_token"])
            || $_POST["secure_token"] !== $_SESSION["secure_token"]
        ) {
            self::render(LANGUAGE["access_denied"], $function, []);
            exit;
        }

        unset($_SESSION["secure_token"]);
    }

    private static function render(?string $errorMessage, callable $callback, ?array $validationErrors = []): void
    {
        Setup::setSession("error_message", $errorMessage);
        Setup::setSession("post", $_POST);
        Setup::setSession("image", $_FILES["image"] ?? null);
        Setup::setSession("validation_errors", $validationErrors);
        $callback();
    }

    public static function Create(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
            return;
        }

        self::checkAccess([ProductGetController::class, "Create"]);

        $preparedData = [];
        foreach (self::$createFields as $field) {
            $preparedData[$field] = $_POST[$field] ?? null;
        }
        $preparedData["image"] = $_FILES["image"] ?? null;
        $preparedData["additional_images"] = $_FILES["additional_images"] ?? null;
        $preparedData["category_id"] = $_SESSION["product_category"]["id"] ?? null;

        $result = ProductService::Create(...$preparedData);

        if ($result["success"] === false) {
            Setup::setSession("errors", $result["errors"] ?? []);
            self::render($result["error"] ?? LANGUAGE["error_creating_product"], [ProductGetController::class, "Create"], $result["errors"] ?? []);
            return;
        }

        $_SESSION["success_message"] = LANGUAGE["success_created_product"];
        Setup::deleteSessions(["post", "image"]);
        Setup::redirect("/products/create", 200);
    }

    public static function Edit(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
            return;
        }

        self::checkAccess([ProductGetController::class, "Edit"]);

        $preparedData = [];
        foreach (self::$editFields as $field) {
            $preparedData[$field] = $_POST[$field] ?? null;
        }
        $preparedData["image"] = $_FILES["image"] ?? null;

        $result = ProductService::Update($_GET["id"], ...$preparedData);

        if ($result["success"] === false) {
            Setup::setSession("errors", $result["errors"] ?? []);
            self::render($result["error"] ?? LANGUAGE["error_creating_product"], [ProductGetController::class, "Create"], $result["errors"] ?? []);
            return;
        }

        $_SESSION["success_message"] = LANGUAGE["success_updated_product"];
        Setup::deleteSessions(["post", "image"]);
        Setup::redirect("/products/edit?id=" . $_GET["id"], 200);
    }
}
