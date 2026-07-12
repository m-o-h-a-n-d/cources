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
                            <th>#</th>
                            <th>Course</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No registered courses found.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($courses as $index => $course): ?>
                                <tr>
                                    <td>
                                        <?= $index + 1 ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($course['name']) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($course['day'] ?? "Not Existing") ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'g:i A',
                                            strtotime($course['start_time']?? "Not Existing")
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'g:i A',
                                            strtotime($course['end_time'] ?? "Not Existing")
                                        ) ?>
                                    </td>

                                    <td>
                                        <span class="badge text-bg-success">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>

<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>