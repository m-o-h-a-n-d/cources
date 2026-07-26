<?php

namespace App\Model;

use Core\Model;
use PDO;

class StudentCourses extends Model
{
    protected static string $table = 'student_courses';
public static function getCoursesDepartment(
    int $studentId
): array {
    $stmt = static::$pdo->prepare(
        "SELECT
            c.id,
            c.name,
            cs.day,
            cs.start_time,
            cs.end_time,
            cs.room
        FROM courses c
        INNER JOIN students s
            ON s.dep_id = c.department_id
        LEFT JOIN course_schedules cs
            ON cs.course_id = c.id
        LEFT JOIN student_courses sc
            ON sc.course_id = c.id
            AND sc.student_id = :student_id
        WHERE s.id = :student_id
        AND sc.id IS NULL"
    );

    $stmt->execute([
        ':student_id' => $studentId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
