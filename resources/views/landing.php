<?php
$pageTitle = 'Landing';
include base_path('resources/views/components/head.php');
?>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fa-solid fa-graduation-cap text-primary me-2"></i>SCMS</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#stats">Statistics</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <a href="/student/login" class="btn btn-brand ms-lg-3">Student Login</a>
        </div>
    </div>
</nav>

<main>
    <section class="container py-5">
        <div class="hero fade-up">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold">Student Course Management System</h1>
                    <p class="lead mb-4">A modern SaaS-style platform to manage registration, attendance, and academic workflows with clarity.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/student" class="btn btn-light">Get Started</a>
                        <a href="/admin/login" class="btn btn-outline-light">Live Demo</a>
                    </div>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="app-card p-4 text-dark">
                        <p class="mb-1 text-muted">Today Registrations</p>
                        <h2 class="fw-bold">1,248</h2>
                        <span class="kpi-pill"><i class="fa-solid fa-arrow-trend-up"></i>+12.4%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="features">
        <h2 class="section-title">Features</h2>
        <div class="row g-3">
            <?php foreach ([['fa-book-open','Course Catalog'],['fa-user-check','Student Profiles'],['fa-calendar-days','Smart Scheduling'],['fa-chart-line','Analytics Dashboard']] as $feature): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="app-card p-3 h-100 hover-lift">
                        <div class="feature-icon mb-3"><i class="fa-solid <?= $feature[0] ?>"></i></div>
                        <h3 class="h6"><?= $feature[1] ?></h3>
                        <p class="text-muted-soft mb-0">Built for speed, consistency, and secure education operations.</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container py-5" id="stats">
        <h2 class="section-title">Statistics</h2>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3"><div class="metric-card"><p class="mb-1 text-muted-soft">Students</p><div class="metric-value">12,430</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="metric-card"><p class="mb-1 text-muted-soft">Courses</p><div class="metric-value">320</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="metric-card"><p class="mb-1 text-muted-soft">Departments</p><div class="metric-value">16</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="metric-card"><p class="mb-1 text-muted-soft">Completion</p><div class="metric-value">94%</div></div></div>
        </div>
    </section>

    <section class="container py-5" id="about">
        <div class="app-card p-4">
            <h2 class="section-title">About The System</h2>
            <p class="mb-0 text-muted-soft">SCMS combines student data, course lifecycle, registration tracking, and departmental insights in one cohesive, responsive dashboard experience.</p>
        </div>
    </section>

    <section class="container py-5" id="contact">
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="app-card p-4 h-100">
                    <h2 class="section-title">Contact</h2>
                    <p class="text-muted-soft">Need onboarding support or custom modules? Send us your request.</p>
                    <div class="mb-2"><i class="fa-solid fa-envelope text-primary me-2"></i>support@scms.edu</div>
                    <div><i class="fa-solid fa-phone text-primary me-2"></i>+966 500 123 456</div>
                </div>
            </div>
            <div class="col-lg-6">
                <form class="app-card p-4">
                    <div class="mb-2"><input class="form-control" placeholder="Name"></div>
                    <div class="mb-2"><input class="form-control" placeholder="Email"></div>
                    <div class="mb-3"><textarea class="form-control" rows="4" placeholder="Message"></textarea></div>
                    <button class="btn btn-brand" type="button" data-toast="Message sent successfully" data-variant="success">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include base_path('resources/views/components/footer.php'); ?>
<?php include base_path('resources/views/components/feedback.php'); ?>
<?php include base_path('resources/views/components/scripts.php'); ?>
