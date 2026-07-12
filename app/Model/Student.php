<?php  


namespace App\Model; 

use Core\Model;
use PDO;



class Student extends Model{

    protected static string $table = 'students';


   
    public static function allWithDepartment()
    {
        $stmt = static::$pdo->prepare(
            "SELECT students.*,
                    departments.name as department_name
             FROM students
             JOIN departments
             ON students.dep_id = departments.id"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}