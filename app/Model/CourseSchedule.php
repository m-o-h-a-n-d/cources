<?php  


namespace App\Model; 

use Core\Model;
use PDO;


class CourseSchedule extends Model
{

    protected  static string $table = 'course_schedules'; 

    public static function allWithCourses()
{
    $stmt = static::$pdo->prepare(
            "SELECT course_schedules.*,
                    courses.name as course_name
             FROM course_schedules
             LEFT JOIN courses
             ON course_schedules.course_id = courses.id"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
}