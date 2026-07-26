<?php
$pageTitle = 'Admin Dashboard';
$activePage = 'admin-dashboard';
$pageHeading = 'Admin Dashboard';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <section class="row g-3 mb-3">
            <div class="col-sm-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Total Students</p><div class="metric-value"><?= isset($data) ? count($data) : 12430 ?></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Total Courses</p><div class="metric-value">320</div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Active Registrations</p><div class="metric-value">6,512</div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Departments</p><div class="metric-value">16</div></div></div>
        </section>

        <section class="row g-3 mb-3">
            <div class="col-lg-4"><div class="app-card p-3"><h3 class="h6">Students per Department</h3><div class="chart-placeholder mt-3"></div></div></div>
            <div class="col-lg-4"><div class="app-card p-3"><h3 class="h6">Course Registrations</h3><div class="chart-placeholder mt-3"></div></div></div>
            <div class="col-lg-4"><div class="app-card p-3"><h3 class="h6">Gender Distribution</h3><div class="chart-placeholder mt-3"></div></div></div>
        </section>

        <section class="row g-3">
            <div class="col-lg-6">
                <div class="app-card p-3 h-100">
                    <h3 class="h6">Recent Students</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Aisha Salem <span class="text-muted-soft float-end">#202301</span></li>
                        <li class="list-group-item">Mohamed Ali <span class="text-muted-soft float-end">#202302</span></li>
                        <li class="list-group-item">Nora Khaled <span class="text-muted-soft float-end">#202303</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="app-card p-3 h-100">
                    <h3 class="h6">Recent Registrations</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Web Engineering - Approved</li>
                        <li class="list-group-item">Linear Algebra - Pending</li>
                        <li class="list-group-item">Cloud Security - Approved</li>
                    </ul>
                </div>
            </div>
        </section>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
