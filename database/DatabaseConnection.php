<?php

class DatabaseConnection
{
    private $connection;

    public function __construct($host, $db_name, $username, $password)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        } catch (PDOException $e) {
            Response::serverError("Грешка при свързване:", $e->getMessage())->send();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        $this->connection = null;
    }

    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();
    }

    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    public function getLastInsertedId()
    {
        return $this->connection->lastInsertId();
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function read($table, $conditions = [], $columns = "*", $limit = null, $offset = null): array
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            throw new InvalidArgumentException("Invalid table name.");
        }

        $sql = "SELECT $columns FROM $table";

        if (!empty($conditions)) {
            $conditionStrings = [];
            foreach ($conditions as $key => $value) {
                if (!preg_match('/^[a-zA-Z0-9_]+$/', $key)) {
                    throw new InvalidArgumentException("Invalid condition key.");
                }
                $conditionStrings[] = "$key LIKE :$key";
            }
            $sql .= " WHERE " . implode(" AND ", $conditionStrings);
        }

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        if ($offset !== null) {
            $sql .= " OFFSET :offset";
        }

        $stmt = $this->connection->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", "%$value%");
        }

        if ($limit !== null) {
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        }
        if ($offset !== null) {
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions)
    {
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }
        $setString = implode(", ", $setParts);

        $conditionStrings = [];
        foreach ($conditions as $key => $value) {
            $conditionStrings[] = "$key = :condition_$key";
        }
        $conditionString = implode(" AND ", $conditionStrings);

        $sql = "UPDATE $table SET $setString WHERE $conditionString";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":condition_$key", $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $conditions)
    {
        $conditionStrings = [];
        foreach ($conditions as $key => $value) {
            $conditionStrings[] = "$key = :$key";
        }
        $conditionString = implode(" AND ", $conditionStrings);

        $sql = "DELETE FROM $table WHERE $conditionString";
        $stmt = $this->connection->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function count($table, $conditions = []): int
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            throw new InvalidArgumentException("Invalid table name.");
        }

        $sql = "SELECT COUNT(*) FROM $table";

        if (!empty($conditions)) {
            $conditionStrings = [];
            foreach ($conditions as $key => $value) {
                if (!preg_match('/^[a-zA-Z0-9_]+$/', $key)) {
                    throw new InvalidArgumentException("Invalid condition key.");
                }
                $conditionStrings[] = "$key LIKE :$key";
            }
            $sql .= " WHERE " . implode(" AND ", $conditionStrings);
        }

        $stmt = $this->connection->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", "%$value%");
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
