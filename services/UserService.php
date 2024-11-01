<?php

class UserService
{
    public static function read(int $limit, int $offset, ?string $column, ?string $value = ""): array
    {
        global $db;
        $conditions = [];
        
        if ($column && $value) {
            $conditions[$column] = $value;
        }
        
        $users = $db->read("users", $conditions, "*", $limit, $offset);

        return $users;
    }

    public static function total(?string $column, ?string $value): int
    {
        global $db;
        $conditions = [];

        if ($column && $value) {
            $conditions[$column] = $value;
        }

        return $db->count("users", $conditions);
    }
}