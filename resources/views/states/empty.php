<?php
$pageTitle = 'Empty States';
$activePage = 'student-dashboard';
$pageHeading = 'Empty State Pages';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <div class="app-card p-3">
            <div class="empty-state">
                <i class="fa-regular fa-folder-open fa-2x text-muted-soft mb-2"></i>
                <h2 class="h5">No Data Available</h2>
                <p class="text-muted-soft">You do not have any courses registered yet.</p>
                <button class="btn btn-brand">Browse Courses</button>
            </div>
        </div>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/scripts.php'); ?>
