<?php
$pageTitle = 'Courses Management';
$activePage = 'courses-management';
$pageHeading = 'Courses Management';
$courses = $courses ?? [];
$departments = $departments ?? [];
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'created'): ?>
            <div class="alert alert-success">Course has been created successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
            <div class="alert alert-success">Course has been updated successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="alert alert-success">Course has been deleted successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'required'): ?>
            <div class="alert alert-danger">Please fill all required fields.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'delete'): ?>
            <div class="alert alert-danger">Unable to delete course.</div>
        <?php endif; ?>

        <div class="app-card p-3 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h2 class="h5 mb-1">Courses</h2>
                    <p class="text-muted-soft mb-0">Create, update, and manage academic courses.</p>
                </div>
                <button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#courseModal">Add Course</button>
            </div>
        </div>

        <div class="app-card p-3">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($course['id'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($course['name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($course['department_name'] ?? '')) ?></td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-course"
                                        data-bs-toggle="modal"
                                        data-bs-target="#courseModal"
                                        data-course-id="<?= htmlspecialchars((string) ($course['id'] ?? '')) ?>"
                                        data-course-name="<?= htmlspecialchars((string) ($course['name'] ?? '')) ?>"
                                        data-department-id="<?= htmlspecialchars((string) ($course['department_id'] ?? '')) ?>"
                                    >Edit</button>
                                    <form method="post" action="/admin/courses/delete" class="d-inline" onsubmit="return confirm('Delete this course?');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($course['id'] ?? '')) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="courseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseModalTitle">Add Course</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/admin/courses" id="courseForm">
                        <input type="hidden" name="id" id="courseRecordId" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Course Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="courseNameInput" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select name="department_id" id="courseDepartmentInput" class="form-select" required>
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= htmlspecialchars((string) ($department['id'] ?? '')) ?>"><?= htmlspecialchars((string) ($department['name'] ?? '')) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-brand" id="courseModalSubmit">Save Course</button>
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
