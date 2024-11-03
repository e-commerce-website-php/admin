<?php

class BaseController
{
    protected static function checkAuthentication(string $redirectTo = "/auth/login"): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect($redirectTo);
        }
    }

    protected static function generateMetaTags(string $title): string
    {
        $generator = new MetaTagsGenerator();
        return $generator->generate([
            "title" => $title,
        ]);
    }

    protected static function getRequestParameters(): array
    {
        $page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
        $limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : SETTINGS["pagination_items_count"];
        $column = $_GET["column"] ?? null;
        $search = $_GET["search"] ?? null;

        return [$page, $limit, $column, $search];
    }
}
