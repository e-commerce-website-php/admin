<?php

class CategoryService
{
    public static function read(int $limit, int $offset, ?string $column, ?string $value = ""): array
    {
        global $db;
        $conditions = [];

        if ($column && $value) {
            $conditions[$column] = $value;
        }

        $categories = $db->read("categories", $conditions, "*", $limit, $offset);

        return $categories;
    }

    public static function total(?string $column, ?string $value): int
    {
        global $db;
        $conditions = [];

        if ($column && $value) {
            $conditions[$column] = $value;
        }

        return $db->count("categories", $conditions);
    }

    public static function Create(?string $name, ?string $slug, ?string $description, ?string $seo_title, ?string $seo_description, ?string $status, ?string $seo_keywords, ?array $image, ?int $parent_id): array
    {
        $validationResult = CategoryValidator::validateCreateOrUpdate($name, $slug, $seo_title, $seo_description, $status);
        if (!$validationResult["success"]) {
            return $validationResult;
        }

        if (self::get("slug", $slug)["success"] === true) {
            return ["success" => false, "error" => LANGUAGE["slug_uniqueness_error"]];
        }

        if ($parent_id && self::get("parent_id", $parent_id)["success"] === false) {
            return ["success" => false, "error" => LANGUAGE["parent_id_validation_error"]];
        }

        global $db;

        try {
            $db->create("categories", [
                "name" => $name,
                "slug" => $slug,
                "description" => $description,
                "seo_title" => $seo_title,
                "seo_description" => $seo_description,
                "seo_keywords" => $seo_keywords,
                "status" => $status,
                "parent_id" => $parent_id,
            ]);

            if ($image && !empty($image["name"])) {
                $result = UploadService::uploadImage($image);
                if ($result["success"] === false) {
                    throw new Exception($result["error"]);
                }

                $db->update("categories", ["image" => $result["data"]["path"]], ["id" => intval($db->getLastInsertedId())]);
            }

            $db->commit();
            return ["success" => true, "data" => self::get("id", $db->getLastInsertedId())];
        } catch (Exception $e) {
            $db->rollBack();
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public static function Update(
        int $id,
        ?string $name,
        ?string $slug,
        ?string $description,
        ?string $seo_title,
        ?string $seo_description,
        ?string $status,
        ?string $seo_keywords,
        ?array $image,
        ?int $parent_id): array
    {
        $validationResult = CategoryValidator::validateCreateOrUpdate($name, $slug, $seo_title, $seo_description, $status);
        if (!$validationResult["success"]) {
            return $validationResult;
        }

        $category = self::get("id", $id);
        if (!$category["success"]) {
            return ["success" => false, "error" => LANGUAGE["category_not_found"]];
        }

        if ($slug && $slug !== $category["data"]["slug"] && self::get("slug", $slug)["success"] === true) {
            return ["success" => false, "error" => LANGUAGE["slug_uniqueness_error"]];
        }

        if ($parent_id && $parent_id !== $category["data"]["parent_id"] && self::get("parent_id", $parent_id)["success"] === false) {
            return ["success" => false, "error" => LANGUAGE["parent_id_validation_error"]];
        }

        global $db;

        try {
            $db->update("categories", [
                "name" => $name,
                "slug" => $slug,
                "description" => $description,
                "seo_title" => $seo_title,
                "seo_description" => $seo_description,
                "seo_keywords" => $seo_keywords,
                "status" => $status,
                "parent_id" => $parent_id,
            ], ["id" => $id]);

            if ($image && !empty($image["name"])) {
                $result = UploadService::uploadImage($image);
                if ($result["success"] === false) {
                    throw new Exception($result["error"]);
                }

                $db->update("categories", ["image" => $result["data"]["path"]], ["id" => $id]);
                unlink($category["data"]["image"]);
            }

            $db->commit();
            return ["success" => true, "data" => self::get("id", $id)];
        } catch (Exception $e) {
            $db->rollBack();
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public static function get(string $column, int|string $value): array
    {
        global $db;

        if (empty($column) || empty($value)) {
            return ["success" => false, "error" => "Invalid 'column' or 'value'."];
        }

        $categories = $db->read("categories", [$column => $value]);

        if (!empty($categories) && count($categories) > 0) {
            return ["success" => true, "data" => $categories[0]];
        }

        return ["success" => false];
    }
}
