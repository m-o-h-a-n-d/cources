<?php
$pageTitle = 'Student Login';
$bodyClass = 'login-wrap';
include base_path('resources/views/components/head.php');
?>
<div class="app-card login-card fade-up">
    <div class="text-center mb-4">
        <i class="fa-solid fa-user-graduate fa-2x text-primary mb-2"></i>
        <h1 class="h4 mb-1">Student Sign In</h1>
        <p class="text-muted-soft mb-0">Access your courses and profile</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger py-2">Invalid student credentials.</div>
    <?php endif; ?>

    <form method="post" action="/student/login">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="student@school.edu" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="123456" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="studentRemember">
                <label class="form-check-label" for="studentRemember">Remember Me</label>
            </div>
            <a href="#" class="text-primary small">Forgot Password?</a>
        </div>
        <button class="btn btn-brand w-100" type="submit">Login as Student</button>
    </form>
</div>
<?php include base_path('resources/views/components/scripts.php'); ?>
