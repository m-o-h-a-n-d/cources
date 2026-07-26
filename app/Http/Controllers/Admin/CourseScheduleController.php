<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WeekDay;
use App\Model\Course;
use App\Services\CourseScheduleServices;

class CourseScheduleController
{
    public function __construct(
        protected CourseScheduleServices $courseScheduleServices
    ) {
    }

    public function index()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courseSchedules = $this->courseScheduleServices->getAllCourseSchedules();
        $courses = Course::all();
        $weekDays = WeekDay::cases();

        return view(
            'admin/course_schedules',
            compact('courseSchedules', 'courses' , 'weekDays')
        );
    }

    public function store()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $data = [
            'course_id' => (int) ($_POST['course_id'] ?? 0),
            'day' => trim($_POST['day'] ?? ''),
            'start_time' => trim($_POST['start_time'] ?? ''),
            'end_time' => trim($_POST['end_time'] ?? ''),
            'room' => trim($_POST['room'] ?? ''),
        ];

        if (
            empty($data['course_id']) ||
            empty($data['day']) ||
            empty($data['start_time']) ||
            empty($data['end_time']) ||
            empty($data['room']) ||
            WeekDay::tryFrom($data['day']) === null
        ) {
            header('Location: /admin/course-schedules?error=required');
            exit;
        }

        $this->courseScheduleServices->createCourseSchedule($data);

        header('Location: /admin/course-schedules?success=created');
        exit;
    }

    public function update()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courseScheduleId = (int) ($_POST['id'] ?? 0);

        if ($courseScheduleId <= 0) {
            header('Location: /admin/course-schedules?error=update');
            exit;
        }

        $data = [
            'course_id' => (int) ($_POST['course_id'] ?? 0),
            'day' => trim($_POST['day'] ?? ''),
            'start_time' => trim($_POST['start_time'] ?? ''),
            'end_time' => trim($_POST['end_time'] ?? ''),
            'room' => trim($_POST['room'] ?? ''),
        ];

        if (
            empty($data['course_id']) ||
            empty($data['day']) ||
            empty($data['start_time']) ||
            empty($data['end_time']) ||
            empty($data['room']) ||
            WeekDay::tryFrom($data['day']) === null
        ) {
            header('Location: /admin/course-schedules?error=required');
            exit;
        }

        $this->courseScheduleServices->updateCourseSchedule(
            $courseScheduleId,
            $data
        );

        header('Location: /admin/course-schedules?success=updated');
        exit;
    }

    public function delete()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courseScheduleId = (int) ($_POST['id'] ?? 0);

        if ($courseScheduleId <= 0) {
            header('Location: /admin/course-schedules?error=delete');
            exit;
        }

        $this->courseScheduleServices->deleteCourseSchedule(
            $courseScheduleId
        );

        header('Location: /admin/course-schedules?success=deleted');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role'])
            && $_SESSION['auth']['role'] === 'admin';
    }
}