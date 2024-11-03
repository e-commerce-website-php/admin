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
    $statuses = ["active" => "Активен", "inactive"];
    return !empty($category["status"]) ? $statuses[$category["status"]] : "Няма";
}

function displayImage(array $category): string
{
    if (!empty($category["image"])) {
        return '<img src="/' . htmlspecialchars($category["image"]) . '" alt="' . htmlspecialchars($category["name"]) . '" width="60" height="60">';
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
