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
                <div class="col-lg-6">
                    <input class="form-control"
                           placeholder="Search by course name, code, instructor">
                </div>

                <div class="col-lg-3">
                    <select class="form-select">
                        <option>My Department Courses</option>
                    </select>
                </div>

                <div class="col-lg-3 d-grid">
                    <button class="btn btn-brand">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">

            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-xl-3">
                        <article class="app-card p-3 h-100 hover-lift">

                            <span class="badge text-bg-primary mb-2">
                                <?= $course['day']?>
                            </span>

                            <h3 class="h6">
                                <?= htmlspecialchars($course['name']) ?>
                            </h3>

                            <?php if (!empty($course['day'])): ?>
                                <p class="small text-muted-soft mb-1">
                                    start_time: <?= htmlspecialchars($course['start_time']) ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($course['day'])): ?>
                                <p class="small text-muted-soft mb-1">
                                    end_time: <?= htmlspecialchars($course['end_time']) ?>
                                </p>
                            <?php endif; ?>

                            
                            <p class="small text-muted-soft">
                                <?= htmlspecialchars(
                                    $course['room'] ?? 'Unknown Department'
                                
                                ) ?>
                            </p>

                            <button class="btn btn-outline-primary btn-sm">
                                Enroll Now 
                            </button>
                        </article>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No courses available for your department.
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>

<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>