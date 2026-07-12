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

public static function getCoursesDepartment($studentId)
{
    $stmt = static::$pdo->prepare(
        "SELECT
            c.*,
            cs.day,
            cs.start_time,
            cs.end_time,
            cs.room
        FROM courses c
        INNER JOIN students s
            ON s.dep_id = c.department_id
        LEFT JOIN course_schedules cs
            ON cs.course_id = c.id
        WHERE s.id = :student_id"
    );

    $stmt->execute([
        ':student_id' => $studentId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}