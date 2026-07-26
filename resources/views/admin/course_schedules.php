<?php
$pageTitle = 'Course Schedule Management';
$activePage = 'course-schedule-management';
$pageHeading = 'Course Schedule Management';
$courseSchedules = $courseSchedules ?? [];
$courses = $courses ?? [];
$weekDays = $weekDays ?? [];
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'created'): ?>
            <div class="alert alert-success">Course schedule has been created successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
            <div class="alert alert-success">Course schedule has been updated successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="alert alert-success">Course schedule has been deleted successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'required'): ?>
            <div class="alert alert-danger">Please fill all required fields.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'delete'): ?>
            <div class="alert alert-danger">Unable to delete course schedule.</div>
        <?php endif; ?>

        <div class="app-card p-3 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h2 class="h5 mb-1">Course Schedule</h2>
                    <p class="text-muted-soft mb-0">Manage daily course schedules and room assignments.</p>
                </div>
                <button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#courseScheduleModal">Add Schedule</button>
            </div>
        </div>

        <div class="app-card p-3">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Room</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courseSchedules as $courseSchedule): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($courseSchedule['id'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($courseSchedule['course_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($courseSchedule['day'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($courseSchedule['start_time'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($courseSchedule['end_time'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($courseSchedule['room'] ?? '')) ?></td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-course-schedule"
                                        data-bs-toggle="modal"
                                        data-bs-target="#courseScheduleModal"
                                        data-schedule-id="<?= htmlspecialchars((string) ($courseSchedule['id'] ?? '')) ?>"
                                        data-course-id="<?= htmlspecialchars((string) ($courseSchedule['course_id'] ?? '')) ?>"
                                        data-day="<?= htmlspecialchars((string) ($courseSchedule['day'] ?? '')) ?>"
                                        data-start-time="<?= htmlspecialchars((string) ($courseSchedule['start_time'] ?? '')) ?>"
                                        data-end-time="<?= htmlspecialchars((string) ($courseSchedule['end_time'] ?? '')) ?>"
                                        data-room="<?= htmlspecialchars((string) ($courseSchedule['room'] ?? '')) ?>"
                                    >Edit</button>
                                    <form method="post" action="/admin/course-schedules/delete" class="d-inline" onsubmit="return confirm('Delete this schedule?');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($courseSchedule['id'] ?? '')) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="courseScheduleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseScheduleModalTitle">Add Schedule</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/admin/course-schedules" id="courseScheduleForm">
                        <input type="hidden" name="id" id="courseScheduleRecordId" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" id="courseScheduleCourseId" class="form-select" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= htmlspecialchars((string) ($course['id'] ?? '')) ?>"><?= htmlspecialchars((string) ($course['name'] ?? '')) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Day <span class="text-danger">*</span></label>
                                <select name="day" id="courseScheduleDay" class="form-select" required>
                                    <option value="">Select Day</option>
                                        <?php foreach ($weekDays as $weekDay): ?>
                                    <option value="<?= htmlspecialchars($weekDay->value) ?>">
                                        <?= htmlspecialchars($weekDay->value) ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="courseScheduleStartTime" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" id="courseScheduleEndTime" class="form-control" required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Room <span class="text-danger">*</span></label>
                                <input type="text" name="room" id="courseScheduleRoom" class="form-control" placeholder="Room 201" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-brand" id="courseScheduleModalSubmit">Save Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
