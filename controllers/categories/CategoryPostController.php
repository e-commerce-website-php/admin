<?php

class CategoryPostController extends BaseController
{
    private static array $createFields = ["name", "slug", "description", "seo_title", "seo_description", "seo_keywords", "status", "image", "parent_id"];
    private static array $editFields = ["name", "slug", "description", "seo_title", "seo_description", "seo_keywords", "status", "image", "parent_id"];

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
        Setup::setSession("validation_errors", $validationErrors); // Добавена е сесия за грешки валидация
        $callback();
    }

    public static function Create(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
            return;
        }

        self::checkAccess([CategoryGetController::class, "Create"]);

        $preparedData = [];
        foreach (self::$createFields as $field) {
            $preparedData[$field] = $_POST[$field] ?? null;
        }
        $preparedData["image"] = $_FILES["image"] ?? null;

        $result = CategoryService::Create(...$preparedData);

        if ($result["success"] === false) {
            Setup::setSession("errors", $result["errors"] ?? []);
            self::render($result["error"] ?? LANGUAGE["error_creating_category"], [CategoryGetController::class, "Create"], $result["errors"] ?? []);
            return;
        }

        $_SESSION["success_message"] = LANGUAGE["success_created_category"];
        Setup::deleteSessions(["post", "image", "parent_category"]);
        Setup::redirect("/categories/create", 200);
    }

    public static function Edit(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
            return;
        }

        self::checkAccess([CategoryGetController::class, "Edit"]);

        $preparedData = [];
        foreach (self::$editFields as $field) {
            $preparedData[$field] = $_POST[$field] ?? null;
        }
        $preparedData["image"] = $_FILES["image"] ?? null;

        $result = CategoryService::Update($_GET["id"], ...$preparedData);

        if ($result["success"] === false) {
            Setup::setSession("errors", $result["errors"] ?? []);
            self::render($result["error"] ?? LANGUAGE["error_creating_category"], [CategoryGetController::class, "Create"], $result["errors"] ?? []);
            return;
        }

        $_SESSION["success_message"] = LANGUAGE["success_updated_category"];
        Setup::deleteSessions(["post", "image", "parent_category"]);
        Setup::redirect("/categories/edit?id=".$_GET["id"], 200);
    }
}