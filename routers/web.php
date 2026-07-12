<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseScheduleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;

$router->get('/', [FrontendController::class, 'landing']);
$router->get('/landing', [FrontendController::class, 'landing']);
$router->get('/login', [FrontendController::class, 'login']);
$router->get('/student', [FrontendController::class, 'studentDashboard']);
$router->get('/dashboard/student', [FrontendController::class, 'studentDashboard']);
$router->get('/courses', [FrontendController::class, 'courses']);
$router->get('/courses/details', [FrontendController::class, 'courseDetails']);
$router->get('/profile', [FrontendController::class, 'profile']);
$router->get('/my-courses', [FrontendController::class, 'myCourses']);

$router->get('/student/login', [AuthController::class, 'studentLoginForm']);
$router->post('/student/login', [AuthController::class, 'studentLogin']);
// Admin Routes 
$router->get('/admin', [FrontendController::class, 'adminDashboard']);
$router->get('/admin/dashboard', [FrontendController::class, 'adminDashboard']);
// Admin Routes Student  
$router->get('/admin/students', [StudentController::class, 'index']);
$router->post('/admin/students', [StudentController::class, 'store']);
$router->post('/admin/students/update', [StudentController::class, 'update']);
$router->post('/admin/students/delete', [StudentController::class, 'delete']);
// Admin Routes Departments   
$router->get('/admin/departments', [DepartmentController::class, 'index']);
$router->post('/admin/departments', [DepartmentController::class, 'store']);
$router->post('/admin/departments/update', [DepartmentController::class, 'update']);
$router->post('/admin/departments/delete', [DepartmentController::class, 'delete']);
// Admin Routes Courses   
$router->get('/admin/courses', [CourseController::class, 'index']);
$router->post('/admin/courses', [CourseController::class, 'store']);
$router->post('/admin/courses/update', [CourseController::class, 'update']);
$router->post('/admin/courses/delete', [CourseController::class, 'delete']);

// Admin Routes Course Schedules   
$router->get('/admin/course-schedules', [CourseScheduleController::class, 'index']);
$router->post('/admin/course-schedules', [CourseScheduleController::class, 'store']);
$router->post('/admin/course-schedules/update', [CourseScheduleController::class, 'update']);
$router->post('/admin/course-schedules/delete', [CourseScheduleController::class, 'delete']);
$router->get('/admin/registrations', [CourseScheduleController::class, 'index']);


$router->get('/admin/login', [AuthController::class, 'adminLoginForm']);
$router->post('/admin/login', [AuthController::class, 'adminLogin']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/states/empty', [FrontendController::class, 'emptyState']);
$router->get('/states/loading', [FrontendController::class, 'loadingState']);
$router->get('/states/toasts', [FrontendController::class, 'toastState']);
$router->get('/states/modals', [FrontendController::class, 'modalState']);
