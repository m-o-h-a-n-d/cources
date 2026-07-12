<?php
$pageTitle = 'Loading Skeletons';
$activePage = 'student-dashboard';
$pageHeading = 'Loading Skeleton Screens';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <div class="row g-3">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="col-md-6 col-xl-3">
                    <div class="app-card p-3">
                        <div class="skeleton" style="height:20px;width:60%;"></div>
                        <div class="skeleton mt-3" style="height:34px;width:40%;"></div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="app-card p-3 mt-3">
            <div class="skeleton mb-2" style="height:16px;width:30%;"></div>
            <div class="skeleton mb-2" style="height:14px;"></div>
            <div class="skeleton mb-2" style="height:14px;"></div>
            <div class="skeleton" style="height:14px;width:80%;"></div>
        </div>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/scripts.php'); ?>
