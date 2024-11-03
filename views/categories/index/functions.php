<?php

function displayColumn(string $column, array $category): string
{
    if (!empty($category[$column])) {
        return htmlspecialchars($category[$column]);
    } else {
        return "Няма";
    }
}

function displayStatus(array $category): string
{
    $statuses = ["active" => "Активен", "inactive" => "Неактивен"];
    return !empty($category["status"]) ? $statuses[$category["status"]] : "Няма";
}

function displayImage(array $category): string
{
    if (!empty($category["image"])) {
        return '<img class="w-[100px] h-[100px] object-cover" decoding="async" src="/' . htmlspecialchars($category["image"]) . '" alt="' . htmlspecialchars($category["name"]) . '" width="100" height="100">';
    } else {
        return 'Няма';
    }
}

function displayParent(array $category): string {
    if (!empty($category['parent_id'])) {
        return '<a href="/categories?parent_id=' . htmlspecialchars($category["parent_id"]) . '" title="Отиване към категорията"></a>';
    } else {
        return "Няма";
    }
}
