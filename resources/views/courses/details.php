<?php
$pageTitle = 'Course Details';
$activePage = 'courses';
$pageHeading = 'Course Details';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <section class="app-card p-4 mb-3">
            <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
                <div>
                    <h2 class="h4 mb-1">Advanced Web Engineering</h2>
                    <p class="text-muted-soft mb-0">CSE-402 • 4 Credits</p>
                </div>
                <button class="btn btn-brand" data-toast="Course registered" data-variant="success">Register Course</button>
            </div>
            <p class="text-muted-soft">This course covers scalable front-end architecture, API integration patterns, and UX principles for academic systems.</p>
        </section>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="app-card p-3 h-100">
                    <h3 class="h6">Instructor</h3>
                    <p class="mb-1"><strong>Dr. Kareem Al-Fahad</strong></p>
                    <p class="text-muted-soft mb-0">Associate Professor of Software Engineering</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="app-card p-3 h-100">
                    <h3 class="h6">Schedule</h3>
                    <p class="mb-1">Sunday & Tuesday</p>
                    <p class="text-muted-soft mb-0">11:00 AM - 12:30 PM, Room B204</p>
                </div>
            </div>
        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
