<?php

namespace App\Model;

use Core\Model;
use PDO;

class MyCourse extends Model
{
    protected static string $table = 'student_courses';

    public static function getStudentCourses(int $studentId): array
{
    $stmt = static::$pdo->prepare(
        "SELECT
            c.id,
            c.name,
            cs.day,
            cs.start_time,
            cs.end_time,
            cs.room
        FROM student_courses sc
        INNER JOIN courses c
            ON c.id = sc.course_id
        LEFT JOIN course_schedules cs
            ON cs.course_id = c.id
        WHERE sc.student_id = :student_id
        ORDER BY c.name"
    );

    $stmt->execute([
        ':student_id' => $studentId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
