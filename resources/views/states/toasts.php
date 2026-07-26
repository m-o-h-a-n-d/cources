<?php
$pageTitle = 'Toast Notifications';
$activePage = 'student-dashboard';
$pageHeading = 'Toast Notifications';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <div class="app-card p-4 d-flex flex-wrap gap-2">
            <button class="btn btn-success" data-toast="Action succeeded" data-variant="success">Success Toast</button>
            <button class="btn btn-danger" data-toast="An error occurred" data-variant="danger">Error Toast</button>
            <button class="btn btn-warning" data-toast="Please review this step" data-variant="warning">Warning Toast</button>
            <button class="btn btn-primary" data-toast="Information update" data-variant="primary">Info Toast</button>
        </div>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
