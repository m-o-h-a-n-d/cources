<?php
$pageTitle = 'Student Profile';
$activePage = 'profile';
$pageHeading = 'Student Profile';
include base_path('resources/views/components/head.php');
?>

<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>

    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="app-card p-4 text-center h-100">

                    <img
                        src="<?= !empty($student['image'])
                            ? '/images/students/' . $student['image']
                            : 'https://placehold.co/120x120' ?>"
                        class="rounded-circle mb-3"
                        width="120"
                        height="120"
                        alt="avatar">

                    <h2 class="h5 mb-1">
                        <?= htmlspecialchars($student['full_name']) ?>
                    </h2>

                    <p class="text-muted-soft">
                        Student ID : <?= htmlspecialchars($student['student_id']) ?>
                    </p>

                    
                </div>
            </div>

            <div class="col-lg-8">
                <div class="app-card p-4 mb-3">
                    <h3 class="h6 mb-3">Personal Information</h3>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['full_name']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Student ID</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['student_id']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['email']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Age</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['age']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['gender']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['phone']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Parent Phone</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['parent_phone']) ?>"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department ID</label>
                            <input
                                class="form-control"
                                value="<?= htmlspecialchars($student['dep_id']) ?>"
                                readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea
                                class="form-control"
                                rows="3"
                                readonly><?= htmlspecialchars($student['address']) ?></textarea>
                        </div>

                    </div>
                </div>

                
            </div>
        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>

<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>