<?php
$pageTitle = 'System Modals';
$activePage = 'student-dashboard';
$pageHeading = 'Success, Error & Confirmation Modals';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <div class="app-card p-4 d-flex flex-wrap gap-2">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#successModal">Show Success</button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#errorModal">Show Error</button>
            <button class="btn btn-warning" data-confirm="Do you want to remove this record?">Show Confirmation</button>
        </div>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
