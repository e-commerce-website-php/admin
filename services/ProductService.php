<?php

class ProductService
{
    public static function read(int $limit, int $offset, ?string $column, ?string $value = ""): array
    {
        global $db;
        $conditions = [];

        if ($column && $value) {
            $conditions[$column] = $value;
        }

        $products = $db->read("products", $conditions, "*", $limit, $offset);

        return $products;
    }

    public static function total(?string $column, ?string $value): int
    {
        global $db;
        $conditions = [];

        if ($column && $value) {
            $conditions[$column] = $value;
        }

        return $db->count("products", $conditions);
    }

    public static function Create(
        ?string $name,
        ?string $slug,
        ?string $short_description,
        ?string $price,
        ?string $tax,
        ?string $sale_price,
        ?string $stock_quantity,
        ?string $show_stock,
        ?string $sku,
        ?string $description,
        ?array $image,
        ?array $additional_images,
        ?string $category_id,
        ?string $seo_title,
        ?string $seo_description,
        ?string $status,
        ?string $seo_keywords
    ): array {
        $validationResult = ProductValidator::validateCreateOrUpdate($name, $slug, $price, $sku, $status);

        if ($validationResult["success"] === false) {
            return $validationResult;
        }

        if (self::get("slug", $slug)["success"] === true) {
            return ["success" => false, "error" => LANGUAGE["slug_uniqueness_error"]];
        }

        global $db;

        try {
            $db->create("products", [
                "name" => $name,
                "slug" => $slug,
                "short_description" => $short_description,
                "description" => $description,
                "price" => $price,
                "tax" => $tax,
                "sale_price" => $sale_price,
                "stock_quantity" => $stock_quantity,
                "show_stock" => $show_stock,
                "sku" => $sku,
                "category_id" => $category_id,
                "seo_title" => $seo_title,
                "seo_description" => $seo_description,
                "seo_keywords" => $seo_keywords,
                "status" => $status,
            ]);

            $productId = $db->getLastInsertedId();

            if ($image && !empty($image["name"])) {
                $result = UploadService::uploadImage($image);
                
                if ($result["success"] === false) {
                    throw new Exception($result["error"]);
                }

                $db->update("products", ["image" => $result["data"]["path"]], ["id" => $productId]);
            }

            if (isset($additional_images) && !empty($additional_images["name"][0])) {
                $uploadedImagePaths = [];

                foreach ($additional_images["name"] as $key => $imageName) {
                    $image = [
                        "name" => $additional_images["name"][$key],
                        "type" => $additional_images["type"][$key],
                        "tmp_name" => $additional_images["tmp_name"][$key],
                        "error" => $additional_images["error"][$key],
                        "size" => $additional_images["size"][$key]
                    ];

                    if (!empty($image["name"])) {
                        $result = UploadService::uploadImage($image);

                        if ($result["success"] === false) {
                            throw new Exception($result["error"]);
                        }

                        $uploadedImagePaths[] = $result["data"]["path"];
                    }
                }

                $db->update("products", ["additional_images" => json_encode($uploadedImagePaths)], ["id" => $productId]);
            }

            $db->commit();
            return ["success" => true, "data" => self::get("id", $productId)];
        } catch (Exception $e) {
            $db->rollBack();
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public static function Update(
        string $id,
        ?string $name,
        ?string $slug,
        ?string $short_description,
        ?string $price,
        ?string $tax,
        ?string $sale_price,
        ?string $stock_quantity,
        ?string $show_stock,
        ?string $sku,
        ?string $description,
        ?array $image,
        ?array $additional_images,
        ?string $seo_title,
        ?string $seo_description,
        ?string $status,
        ?string $seo_keywords
    ): array {
        $validationResult = ProductValidator::validateCreateOrUpdate($name, $slug, $price, $sku, $status);
        if (!$validationResult["success"]) {
            return $validationResult;
        }

        $product = self::get("id", $id);
        if (!$product["success"]) {
            return ["success" => false, "error" => LANGUAGE["category_not_found"]];
        }

        if ($slug) {
            $existingSlug = self::get("slug", $slug);
            
            if ($existingSlug["success"] === true && $existingSlug["data"]["id"] !== $product["data"]["id"]) {
                return ["success" => false, "error" => LANGUAGE["slug_uniqueness_error"]];
            }
        }

        global $db;

        try {
            $db->update("products", [
                "name" => $name,
                "slug" => $slug,
                "short_description" => $short_description,
                "description" => $description,
                "price" => $price,
                "tax" => $tax,
                "sale_price" => $sale_price,
                "stock_quantity" => $stock_quantity,
                "show_stock" => $show_stock,
                "sku" => $sku,
                "seo_title" => $seo_title,
                "seo_description" => $seo_description,
                "seo_keywords" => $seo_keywords,
                "status" => $status,
            ], ["id" => $id]);

            if ($image && !empty($image["name"])) {
                $result = UploadService::uploadImage($image);
                if ($result["success"] === false) {
                    throw new Exception($result["error"]);
                }

                $db->update("products", ["image" => $result["data"]["path"]], ["id" => $id]);

                if (file_exists($product["data"]["image"])) {
                    unlink($product["data"]["image"]);
                }
            }

            if (isset($additional_images) && !empty($additional_images["name"][0])) {
                $uploadedImagePaths = [];

                foreach ($additional_images["name"] as $key => $imageName) {
                    $image = [
                        "name" => $additional_images["name"][$key],
                        "type" => $additional_images["type"][$key],
                        "tmp_name" => $additional_images["tmp_name"][$key],
                        "error" => $additional_images["error"][$key],
                        "size" => $additional_images["size"][$key]
                    ];

                    if (!empty($image["name"])) {
                        $result = UploadService::uploadImage($image);

                        if ($result["success"] === false) {
                            throw new Exception($result["error"]);
                        }

                        $uploadedImagePaths[] = $result["data"]["path"];
                    }
                }

                $db->update("products", ["additional_images" => json_encode($uploadedImagePaths)], ["id" => $id]);

                if (isset($product["data"]["additional_images"]) && is_array($product["data"]["additional_images"])) {
                    foreach ($product["data"]["additional_images"] as $additionalImage) {
                        if (file_exists($additionalImage)) {
                            unlink($additionalImage);
                        }
                    }
                }
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

        $products = $db->read("products", [$column => $value]);

        if (!empty($products) && count($products) > 0) {
            $product = $products[0];
            $product["additional_images"] = json_decode($product["additional_images"]);

            return ["success" => true, "data" => $product];
        }

        return ["success" => false];
    }

    public static function deleteById(string $id): array
    {
        $product = self::get("id", $id);

        if ($product["success"] === false) {
            return ["success" => false, "error" => LANGUAGE["product_not_found"]];
        }

        global $db;

        $isDeleted = $db->delete("products", ["id" => $id]);

        if (!$isDeleted) {
            $db->rollBack();
            return ["success" => false, "error" => LANGUAGE["delete_failed"]];
        }

        $db->commit();

        if (isset($product["data"]["image"]) && file_exists($product["data"]["image"])) {
            unlink($product["data"]["image"]);
        }

        if (isset($product["data"]["additional_images"]) && is_array($product["data"]["additional_images"])) {
            foreach ($product["data"]["additional_images"] as $additionalImage) {
                if (file_exists($additionalImage)) {
                    unlink($additionalImage);
                }
            }
        }

        return ["success" => true];
    }
}