<?php
$pageTitle = 'Departments Management';
$activePage = 'departments-management';
$pageHeading = 'Departments Management';
$departments = $departments ?? [];
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'created'): ?>
            <div class="alert alert-success">Department has been created successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
            <div class="alert alert-success">Department has been updated successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="alert alert-success">Department has been deleted successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'required'): ?>
            <div class="alert alert-danger">Please fill all required fields.</div>
        <?php endif; ?>

        <div class="app-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h5 mb-1">Departments</h2>
                    <p class="text-muted-soft mb-0">Create, edit, and manage academic departments.</p>
                </div>
                <button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#departmentModal">Add Department</button>
            </div>

            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($departments as $department): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($department['id'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($department['name'] ?? ($department['name'] ?? '')) ) ?></td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-department"
                                        data-bs-toggle="modal"
                                        data-bs-target="#departmentModal"
                                        data-dep-id="<?= htmlspecialchars((string) ($department['id'] ?? '')) ?>"
                                        data-dep-name="<?= htmlspecialchars((string) ($department['name'] ?? ($department['name'] ?? ''))) ?>"
                                    >Edit</button>
                                    <form method="post" action="/admin/departments/delete" class="d-inline" onsubmit="return confirm('Delete this department?');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($department['id'] ?? '')) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="departmentModalTitle">Add Department</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/admin/departments" id="departmentForm">
                        <input type="hidden" name="id" id="departmentRecordId" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Department Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="departmentNameInput" class="form-control" required>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-brand" id="departmentModalSubmit">Save Department</button>
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
