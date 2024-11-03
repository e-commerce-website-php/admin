<?php

class CategoryValidator
{
    public static function validateCreate(?string $name, ?string $slug, ?string $meta_title, ?string $meta_description): array
    {
        $errors = [];

        if (mb_strlen($name, 'UTF-8') === 0 || mb_strlen($name, 'UTF-8') > 30) {
            $errors["category_name_validation_error"] = LANGUAGE["category_name_validation_error"];
        }

        if (mb_strlen($slug) === 0 || mb_strlen($slug) > 30) {
            $errors["category_slug_validation_error"] = LANGUAGE["category_slug_validation_error"];
        }

        if (mb_strlen($meta_title) > 70) {
            $errors["meta_title_validation_error"] = LANGUAGE["meta_title_validation_error"];
        }

        if (mb_strlen($meta_description) > 170) {
            $errors["meta_description_validation_error"] = LANGUAGE["meta_description_validation_error"];
        }

        if (count($errors) > 0) {
            return ["success" => false, "errors" => $errors];
        }

        return ["success" => true];
    }
}
