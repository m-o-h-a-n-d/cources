<?php 
namespace App\Model;
use Core\Model; 
use PDO;


class Course extends Model
{
protected static string $table = 'courses';

public static function allWithDepartment()
{
    $stmt = static::$pdo->prepare(
            "SELECT courses.*,
                    departments.name as department_name
             FROM courses
             LEFT JOIN departments
             ON courses.department_id = departments.id"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}