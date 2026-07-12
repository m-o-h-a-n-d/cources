<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseScheduleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Student\MyCoursesController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\StudentCoursesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

$router->get('/', [FrontendController::class, 'landing']);
$router->get('/courses/details', [FrontendController::class, 'courseDetails']);
$router->get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

$router->get('/student/login', [AuthController::class, 'studentLoginForm']);
$router->post('/student/login', [AuthController::class, 'studentLogin']);

$router->get('/admin/login', [AuthController::class, 'adminLoginForm']);
$router->post('/admin/login', [AuthController::class, 'adminLogin']);

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

$router->middleware(StudentMiddleware::class)
    ->group(function ($router) {

        $router->get(
            '/dashboard/student',
            [FrontendController::class, 'studentDashboard']
        );

        $router->get(
            '/profile',
            [ProfileController::class, 'index']
        );

        $router->get(
            '/student',
            [StudentCoursesController::class, 'index']
        );

        $router->post(
            '/student/courses/enroll',
            [StudentCoursesController::class, 'store']
        );

        $router->get(
            '/student/courses/show',
            [StudentCoursesController::class, 'show']
        );

        $router->get(
            '/student/my-courses',
            [MyCoursesController::class, 'index']
        );
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

$router->middleware(AdminMiddleware::class)
    ->group(function ($router) {

        $router->get(
            '/admin',
            [FrontendController::class, 'adminDashboard']
        );

        $router->get(
            '/admin/dashboard',
            [FrontendController::class, 'adminDashboard']
        );

        // Students
        $router->get(
            '/admin/students',
            [StudentController::class, 'index']
        );

        $router->post(
            '/admin/students',
            [StudentController::class, 'store']
        );

        $router->post(
            '/admin/students/update',
            [StudentController::class, 'update']
        );

        $router->post(
            '/admin/students/delete',
            [StudentController::class, 'delete']
        );

        // Departments
        $router->get(
            '/admin/departments',
            [DepartmentController::class, 'index']
        );

        $router->post(
            '/admin/departments',
            [DepartmentController::class, 'store']
        );

        $router->post(
            '/admin/departments/update',
            [DepartmentController::class, 'update']
        );

        $router->post(
            '/admin/departments/delete',
            [DepartmentController::class, 'delete']
        );

        // Courses
        $router->get(
            '/admin/courses',
            [CourseController::class, 'index']
        );

        $router->post(
            '/admin/courses',
            [CourseController::class, 'store']
        );

        $router->post(
            '/admin/courses/update',
            [CourseController::class, 'update']
        );

        $router->post(
            '/admin/courses/delete',
            [CourseController::class, 'delete']
        );

        // Course Schedules
        $router->get(
            '/admin/course-schedules',
            [CourseScheduleController::class, 'index']
        );

        $router->post(
            '/admin/course-schedules',
            [CourseScheduleController::class, 'store']
        );

        $router->post(
            '/admin/course-schedules/update',
            [CourseScheduleController::class, 'update']
        );

        $router->post(
            '/admin/course-schedules/delete',
            [CourseScheduleController::class, 'delete']
        );

        $router->get(
            '/admin/registrations',
            [CourseScheduleController::class, 'index']
        );
    });