<?php

class ProductDeleteController extends BaseController
{
    public static function Delete(): void
    {
        if (!AuthService::isAuth()) {
            Setup::redirect("/auth/login");
        }

        [,,,,$id] = self::getRequestParameters();

        if (!$id) {
            Response::badRequest(LANGUAGE["product_not_found"])->send();
        }

        $result = ProductService::deleteById($id);

        if ($result["success"] === false) {
            Response::badRequest($result["error"])->send();
        }

        $_SESSION["success_message"] = LANGUAGE["success_deleted"];
        Response::ok()->send();
    }
}