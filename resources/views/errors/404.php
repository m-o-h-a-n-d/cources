<?php
$pageTitle = '404';
$bodyClass = 'error-404';
include base_path('resources/views/components/head.php');
?>
<div class="app-card p-5">
    <div class="display-1 fw-bold text-primary">404</div>
    <h1 class="h3 mt-2">Page Not Found</h1>
    <p class="text-muted-soft">The page you requested does not exist or has been moved.</p>
    <a class="btn btn-brand" href="#">Back to Dashboard</a>
</div>
<?php include base_path('resources/views/components/scripts.php'); ?>
