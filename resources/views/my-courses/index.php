<?php
$pageTitle = 'My Courses';
$activePage = 'my-courses';
$pageHeading = 'My Courses';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>
        <section class="app-card p-3">
            <h2 class="h5 mb-3">Registered Courses Table</h2>
            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Schedule</th>
                            <th>Instructor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Data Structures</td><td><span class="badge text-bg-success">Active</span></td><td>Mon 10:00 AM</td><td>Dr. Omar</td></tr>
                        <tr><td>Operating Systems</td><td><span class="badge text-bg-warning">Pending</span></td><td>Tue 12:00 PM</td><td>Dr. Lina</td></tr>
                        <tr><td>UI Design</td><td><span class="badge text-bg-primary">Completed</span></td><td>Wed 2:00 PM</td><td>Mr. Faisal</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
