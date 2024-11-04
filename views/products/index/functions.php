<?php

function displayColumn(string $column, array $category): string
{
    if (!empty($category[$column])) {
        return htmlspecialchars($category[$column]);
    } else {
        return "Няма";
    }
}

function displayPrice(array $product): string
{
    if (!empty($product["price"]) && floatval($product["price"]) > 0) {
        return htmlspecialchars($product["price"]) . " BGN";
    } else {
        return "Няма";
    }
}

function displayTax(array $product): string
{
    if (!empty($product["tax"]) && intval($product["tax"]) > 0) {
        return htmlspecialchars($product["tax"]) . "%";
    } else {
        return "Няма";
    }
}

function displayStatus(array $product): string
{
    $statuses = [
        "publish" => "Публикуван",
        "draft" => "Чернова",
        "pending" => "Изчакване",
        "private" => "Частен",
    ];
    return !empty($product["status"]) ? $statuses[$product["status"]] : "Няма";
}

function displayImage(array $product): string
{
    if (!empty($product["image"])) {
        return '<img class="w-[100px] h-[100px] object-cover" decoding="async" src="/' . htmlspecialchars($product["image"]) . '" alt="' . htmlspecialchars($product["name"]) . '" width="100" height="100">';
    } else {
        return 'Няма';
    }
}

function displayCategory(array $product): string {
    if (!empty($product['category_id']) && !empty($product['category'])) {
        return '<a href="/categories?edit=' . htmlspecialchars($product['category_id']) . '" title="Отиване към категорията">' . $product["category"]["name"] . '</a>';
    } else {
        return "Няма";
    }
}
