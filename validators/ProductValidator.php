<?php

class ProductValidator
{
    public static function validateCreateOrUpdate(?string $name, ?string $slug, ?string $price, ?string $sku, ?string $status): array
    {
        $errors = [];

        if (mb_strlen($name, 'UTF-8') === 0 || mb_strlen($name, 'UTF-8') > 30) {
            $errors["product_name_validation_error"] = LANGUAGE["product_name_validation_error"];
        }
        
        if (mb_strlen($slug) === 0 || mb_strlen($slug) > 30) {
            $errors["product_slug_validation_error"] = LANGUAGE["product_slug_validation_error"];
        }
        
        if (floatval($price) < 0) {
            $errors["product_price_validation_error"] = LANGUAGE["product_price_validation_error"];
        }
        
        if (mb_strlen($sku) === 0) {
            $errors["product_sku_validation_error"] = LANGUAGE["product_sku_validation_error"];
        }
        
        if ($status !== "publish" && $status !== "draft" && $status !== "pending" && $status !== "private") {
            $errors["status_validation_error"] = LANGUAGE["status_validation_error"];
        }
        
        if (count($errors) > 0) {
            return ["success" => false, "errors" => $errors];
        }

        return ["success" => true];
    }
}
