<?php

namespace Core;

use PDO;

abstract class Model
{
    protected static PDO $pdo; //  PDO instance for database connection
    protected static string $table; //  Table name associated with the model

    public static function setConnection(PDO $pdo)
    {
        static::$pdo = $pdo; //  Static method to set the PDO instance for database connection 
    }

    public static function all()
    {
        $stmt = static::$pdo->prepare(
            "SELECT * FROM " . static::$table 
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function find($id)
    {
        $stmt = static::$pdo->prepare(
            "SELECT * FROM " . static::$table . " WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 


    public static function findByEmail($email)
    {
        $stmt = static::$pdo->prepare(
            "SELECT * FROM " . static::$table . " WHERE email = ?"
        );

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function create(array $array ){ 

    $columns = implode(', ', array_keys($array));
    $placeholders = implode(
        ', ',
        array_fill(0, count($array), '?')
    );

    $sql = "INSERT INTO "
        . static::$table .
        " ($columns)
        VALUES ($placeholders)";

    $stmt = static::$pdo->prepare($sql);

    return $stmt->execute(
        array_values($array)
    );
    }


    public static function update(array $array, $id)
    {
        $setClause = implode(
            ', ',
            array_map(fn($key) => "$key = ?", array_keys($array))
        );

        $sql = "UPDATE " . static::$table . " SET $setClause WHERE id = ?";

        $stmt = static::$pdo->prepare($sql);

        return $stmt->execute(
            [...array_values($array), $id]
        );  
    }

    public static function delete($id)
    {
        $stmt = static::$pdo->prepare(
            "DELETE FROM " . static::$table . " WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }



    
}