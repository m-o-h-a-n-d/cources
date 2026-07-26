<?php
$pageTitle = 'Students Management';
$activePage = 'students-management';
$pageHeading = 'Students Management';
$data = $data ?? [];
$departments = $departments ?? [];
include base_path('resources/views/components/head.php');

?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Student has been added successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">Student has been deleted successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'required'): ?>
            <div class="alert alert-danger">Please fill all required fields.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'delete'): ?>
            <div class="alert alert-danger">Unable to delete student.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'update'): ?>
            <div class="alert alert-danger">Unable to update student.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'image'): ?>
            <div class="alert alert-danger">Please upload a valid student image.</div>
        <?php endif; ?>

        <div class="app-card p-3 mb-3">
            <div class="row g-2">
                
                <div class="col-md-3 d-grid"><button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#studentModal">Add Student</button></div>
            </div>
        </div>

        <div class="app-card p-3">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                           
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Parent Phone</th>
                            <th>Department</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $student): ?>
                            <tr>
                               
                                <td><?= htmlspecialchars((string) ($student['student_id'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['full_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['email'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['age'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['gender'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['phone'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['parent_phone'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($student['department_name'] ?? ($student['department_name'] ?? ''))) ?></td>
                                <td><?= htmlspecialchars((string) ($student['address'] ?? '')) ?></td>
                                <td>
                                    <?php if (! empty($student['image'])): ?>
                                        <a href="/images/students/<?= htmlspecialchars((string) $student['image']) ?>" target="_blank" rel="noopener">View</a>
                                    <?php else: ?>
                                        <span class="text-muted-soft">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-student"
                                        data-bs-toggle="modal"
                                        data-bs-target="#studentModal"
                                        data-record-id="<?= htmlspecialchars((string) ($student['id'] ?? '')) ?>"
                                        data-student-id="<?= htmlspecialchars((string) ($student['student_id'] ?? '')) ?>"
                                        data-full-name="<?= htmlspecialchars((string) ($student['full_name'] ?? '')) ?>"
                                        data-age="<?= htmlspecialchars((string) ($student['age'] ?? '')) ?>"
                                        data-gender="<?= htmlspecialchars((string) ($student['gender'] ?? '')) ?>"
                                        data-phone="<?= htmlspecialchars((string) ($student['phone'] ?? '')) ?>"
                                        data-parent-phone="<?= htmlspecialchars((string) ($student['parent_phone'] ?? '')) ?>"
                                        data-dep-id="<?= htmlspecialchars((string) ($student['dep_id'] ?? '')) ?>"
                                        data-address="<?= htmlspecialchars((string) ($student['address'] ?? '')) ?>"
                                        data-image="<?= htmlspecialchars((string) ($student['image'] ?? '')) ?>"
                                        data-email="<?= htmlspecialchars((string) ($student['email'] ?? '')) ?>"
                                    >Edit</button>
                                    <form method="post" action="/admin/students/delete" class="d-inline" onsubmit="return confirm('Delete this student?');">
                                        <input type="hidden" name="student_id" value="<?= htmlspecialchars((string) ($student['id'] ?? '')) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentModalTitle">Add Student</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/admin/students" enctype="multipart/form-data" id="studentForm">
                        <input type="hidden" name="record_id" id="studentRecordId" value="">
                        <input type="hidden" name="current_image" id="studentCurrentImage" value="">
                        <div class="modal-body">
                        <div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">
            Student ID <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="student_id"
            id="studentStudentId"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Full Name <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="full_name"
            id="studentFullName"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Email <span class="text-danger">*</span>
        </label>
        <input
            type="email"
            name="email"
            id="studentEmail"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Password <span class="text-danger">*</span>
        </label>
        <input
            type="password"
            name="password"
            id="studentPassword"
            class="form-control"
        >
        <small class="text-muted">
           if you leave the password field empty, the existing password will remain unchanged.
        </small>
    </div>

    <div class="col-md-4">
        <label class="form-label">
            Age <span class="text-danger">*</span>
        </label>
        <input
            type="number"
            name="age"
            id="studentAge"
            class="form-control"
            min="1"
            max="120"
            required
        >
    </div>

    <div class="col-md-4">
        <label class="form-label">
            Gender <span class="text-danger">*</span>
        </label>
        <select
            name="gender"
            id="studentGender"
            class="form-select"
            required
        >
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">
            Department <span class="text-danger">*</span>
        </label>
        <select
            name="dep_id"
            id="studentDepId"
            class="form-select"
            required
        >
            <option value="">Select Department</option>

            <?php foreach ($departments as $department): ?>
                <option
                    value="<?= htmlspecialchars((string) ($department['id'] ?? '')) ?>">
                    <?= htmlspecialchars((string) ($department['name'] ?? '')) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Phone <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="phone"
            id="studentPhone"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Parent Phone <span class="text-danger">*</span>
        </label>
        <input
            type="text"
            name="parent_phone"
            id="studentParentPhone"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-12">
        <label class="form-label">
            Address <span class="text-danger">*</span>
        </label>
        <textarea
            name="address"
            id="studentAddress"
            class="form-control"
            rows="2"
            required
        ></textarea>
    </div>

    <div class="col-md-12">
        <label class="form-label">
            Image <span class="text-danger">*</span>
        </label>

        <input
            type="file"
            name="image"
            id="studentImageInput"
            class="d-none"
            accept="image/*"
        >

        <div
            class="image-dropzone"
            id="studentImageDropzone"
            role="button"
            tabindex="0"
            data-input="#studentImageInput"
        >
            <div class="image-dropzone-icon">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>

            <div>
                <strong id="studentImageLabel">
                    Drag & Drop image here
                </strong>

                <div class="text-muted-soft small">
                    or click to browse files
                </div>
            </div>

            <div
                class="image-preview"
                id="studentImagePreview"
            >
                <span class="text-muted-soft small">
                    No image selected
                </span>
            </div>
        </div>
    </div>

</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-brand" id="studentModalSubmit">Save Student</button>
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
