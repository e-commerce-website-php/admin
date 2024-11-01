<?php

function displayFullName(array $user): string
{
    if (!empty($user["first_name"]) && !empty($user["last_name"])) {
        return htmlspecialchars($user["first_name"]) . " " . htmlspecialchars($user["last_name"]);
    } elseif (!empty($user["first_name"])) {
        return htmlspecialchars($user["first_name"]);
    } elseif (!empty($user["last_name"])) {
        return htmlspecialchars($user["last_name"]);
    } else {
        return "Няма";
    }
}

function displayPhoneNumber(array $user): string
{
    return !empty($user["phone_number"]) ? htmlspecialchars($user["phone_number"]) : "Няма";
}

function displayAddress(array $user): string
{
    return !empty($user["address"]) ? htmlspecialchars($user["address"]) : "Няма";
}

function displayCity(array $user): string
{
    return !empty($user["city"]) ? htmlspecialchars($user["city"]) : "Няма";
}

function displayState(array $user): string
{
    return !empty($user["state"]) ? htmlspecialchars($user["state"]) : "Няма";
}

function displayPostalCode(array $user): string
{
    return !empty($user["postal_code"]) ? htmlspecialchars($user["postal_code"]) : "Няма";
}

function displayCountry(array $user): string
{
    return !empty($user["country"]) ? htmlspecialchars($user["country"]) : "Няма";
}

function displayRoleAccess(array $user): string
{
    $roles = ["admin" => "Администратор", "user" => "Потребител"];
    return !empty($user["role_access"]) ? $roles[$user["role_access"]] : "Няма";
}

function displayCreatedAt(array $user): string
{
    if (!empty($user["created_at"])) {
        $dateTime = new DateTime($user["created_at"]);
        return $dateTime->format('d.m.Y H:i');
    }
    return "Няма";
}

function displayStatus(array $user): string
{
    $statuses = ["active" => "Активен", "inactive" => "Неактивен", "banned" => "Забранен"];
    return !empty($user["status"]) ? $statuses[$user["status"]] : "Няма";
}
