<?php
$pageTitle = 'Registration Management';
$activePage = 'registration-management';
$pageHeading = 'Registration Management';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <div class="app-card p-3">
            <h2 class="h5">Registration Management</h2>
            <div class="table-responsive mt-3">
                <table class="table table-modern align-middle">
                    <thead><tr><th>Student</th><th>Course</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        <tr><td>Nora Khaled</td><td>Cloud Security</td><td>2026-07-10</td><td><span class="badge text-bg-warning">Pending</span></td><td><button class="btn btn-sm btn-outline-success">Approve</button> <button class="btn btn-sm btn-outline-danger">Reject</button></td></tr>
                        <tr><td>Ali Faisal</td><td>Data Mining</td><td>2026-07-09</td><td><span class="badge text-bg-success">Approved</span></td><td><button class="btn btn-sm btn-outline-primary">Details</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
