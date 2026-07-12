<?php
$pageTitle = 'Courses';
$activePage = 'courses';
$pageHeading = 'Courses';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <div class="app-card p-3 mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6"><input class="form-control" placeholder="Search by course name, code, instructor"></div>
                <div class="col-lg-3">
                    <select class="form-select">
                        <option>All Departments</option>
                        <option>Computer Science</option>
                        <option>Business</option>
                        <option>Engineering</option>
                    </select>
                </div>
                <div class="col-lg-3 d-grid"><button class="btn btn-brand">Apply Filters</button></div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <?php foreach (['Advanced PHP', 'UI/UX Fundamentals', 'Machine Learning Basics', 'Cloud Computing'] as $course): ?>
                <div class="col-md-6 col-xl-3">
                    <article class="app-card p-3 h-100 hover-lift">
                        <span class="badge text-bg-primary mb-2">3 Credits</span>
                        <h3 class="h6"><?= $course ?></h3>
                        <p class="small text-muted-soft">Build practical understanding with modern labs and weekly projects.</p>
                        <button class="btn btn-outline-primary btn-sm">View Details</button>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link">Previous</a></li>
                <li class="page-item active"><a class="page-link">1</a></li>
                <li class="page-item"><a class="page-link">2</a></li>
                <li class="page-item"><a class="page-link">3</a></li>
                <li class="page-item"><a class="page-link">Next</a></li>
            </ul>
        </nav>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
