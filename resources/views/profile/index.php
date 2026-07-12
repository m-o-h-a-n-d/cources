<?php
$pageTitle = 'Student Profile';
$activePage = 'profile';
$pageHeading = 'Student Profile';
include base_path('resources/views/components/head.php');
?>
<div class="page-shell">
    <?php include base_path('resources/views/components/sidebar.php'); ?>
    <main class="main-content">
        <?php include base_path('resources/views/components/topbar.php'); ?>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="app-card p-4 text-center h-100">
                    <img src="https://placehold.co/120x120" class="rounded-circle mb-3" alt="avatar">
                    <h2 class="h5 mb-1">Sarah Ahmad</h2>
                    <p class="text-muted-soft">Computer Science Student</p>
                    <button class="btn btn-outline-primary btn-sm">Upload Avatar</button>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="app-card p-4 mb-3">
                    <h3 class="h6">Personal Information</h3>
                    <div class="row g-2">
                        <div class="col-md-6"><input class="form-control" value="Sarah"></div>
                        <div class="col-md-6"><input class="form-control" value="Ahmad"></div>
                        <div class="col-md-6"><input class="form-control" value="sarah@school.edu"></div>
                        <div class="col-md-6"><input class="form-control" value="20230021"></div>
                    </div>
                    <button class="btn btn-brand mt-3" data-toast="Profile updated" data-variant="success">Update Profile</button>
                </div>
                <div class="app-card p-4">
                    <h3 class="h6">Change Password</h3>
                    <div class="row g-2">
                        <div class="col-md-4"><input type="password" class="form-control" placeholder="Current"></div>
                        <div class="col-md-4"><input type="password" class="form-control" placeholder="New"></div>
                        <div class="col-md-4"><input type="password" class="form-control" placeholder="Confirm"></div>
                    </div>
                    <button class="btn btn-outline-primary mt-3" data-confirm="Save new password?">Change Password</button>
                </div>
            </div>
        </div>

        <?php include base_path('resources/views/components/footer.php'); ?>
    </main>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
