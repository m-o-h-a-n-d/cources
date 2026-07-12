<?php
$pageTitle = 'Student Dashboard';
$activePage = 'student-dashboard';
$pageHeading = 'Student Dashboard';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <section class="app-card p-4 mb-3">
            <h2 class="h4">Welcome, Sarah 👋</h2>
            <p class="text-muted-soft mb-0">Track your courses, schedules, and notifications in one place.</p>
        </section>

        <section class="row g-3 mb-3">
            <div class="col-md-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Registered Courses</p><div class="metric-value">6</div></div></div>
            <div class="col-md-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Credits</p><div class="metric-value">18</div></div></div>
            <div class="col-md-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Upcoming Exams</p><div class="metric-value">2</div></div></div>
            <div class="col-md-6 col-xl-3"><div class="metric-card"><p class="text-muted-soft mb-1">Attendance</p><div class="metric-value">97%</div></div></div>
        </section>

        <section class="row g-3">
            <div class="col-xl-7">
                <div class="app-card p-3 h-100">
                    <h3 class="h6">Upcoming Courses</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">Data Structures <span class="text-muted-soft">Mon 10:00 AM</span></li>
                        <li class="list-group-item d-flex justify-content-between">Database Systems <span class="text-muted-soft">Tue 12:00 PM</span></li>
                        <li class="list-group-item d-flex justify-content-between">Web Engineering <span class="text-muted-soft">Wed 9:30 AM</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="app-card p-3 mb-3">
                    <h3 class="h6">Registered Courses</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-bg-primary">Algorithms</span>
                        <span class="badge text-bg-success">Operating Systems</span>
                        <span class="badge text-bg-warning">Statistics</span>
                    </div>
                </div>
                <div class="app-card p-3">
                    <h3 class="h6">Notifications</h3>
                    <p class="small mb-2"><i class="fa-solid fa-bell text-warning me-2"></i>Registration closes in 2 days.</p>
                    <p class="small mb-0"><i class="fa-solid fa-circle-check text-success me-2"></i>Profile updated successfully.</p>
                </div>
            </div>
        </section>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
