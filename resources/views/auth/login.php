<?php
$pageTitle = 'Student Login';
$bodyClass = 'login-wrap';
include base_path('resources/views/components/head.php');
?>
<div class="app-card login-card fade-up">
    <div class="text-center mb-4">
        <i class="fa-solid fa-user-graduate fa-2x text-primary mb-2"></i>
        <h1 class="h4 mb-1">Welcome Back</h1>
        <p class="text-muted-soft mb-0">Sign in to your student dashboard</p>
    </div>
    <form>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="student@school.edu">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="********">
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            <a href="#" class="text-primary small">Forgot Password?</a>
        </div>
        <button class="btn btn-brand w-100" type="button" data-toast="Login successful" data-variant="success">Login</button>
    </form>
</div>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
