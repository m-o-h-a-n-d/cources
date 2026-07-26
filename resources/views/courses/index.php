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
                    <input
                        class="form-control"
                        placeholder="Search by course name"
                    >
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

                            <?php if (!empty($course['day'])): ?>
                                <span class="badge text-bg-primary mb-2">
                                    <?= htmlspecialchars($course['day']) ?>
                                </span>
                            <?php endif; ?>

                            <h3 class="h6">
                                <?= htmlspecialchars($course['name']) ?>
                            </h3>

                            <?php if (!empty($course['start_time'])): ?>
                                <p class="small text-muted-soft mb-1">
                                    Start:
                                    <?= date(
                                        'g:i A',
                                        strtotime($course['start_time'])
                                    ) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($course['end_time'])): ?>
                                <p class="small text-muted-soft mb-1">
                                    End:
                                    <?= date(
                                        'g:i A',
                                        strtotime($course['end_time'])
                                    ) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($course['room'])): ?>
                                <p class="small text-muted-soft">
                                    Room:
                                    <?= htmlspecialchars($course['room']) ?>
                                </p>
                            <?php endif; ?>

                            <form
                                method="POST"
                                action="/student/courses/enroll"
                            >
                                <input
                                    type="hidden"
                                    name="course_id"
                                    value="<?= $course['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    Enroll Now
                                </button>
                            </form>

                        </article>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">
                    <div class="alert alert-success text-center">
                        🎉 You have enrolled in all available courses.
                    </div>
                </div>

            <?php endif; ?>

        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>

<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>

<?php if (isset($_SESSION['success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    SCMS.toast(
        '<?= $_SESSION['success'] ?>',
        'success'
    );
});
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>