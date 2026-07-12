<?php $pageHeading = $pageHeading ?? 'Dashboard'; ?>
<header class="topbar d-flex align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary" data-action="toggle-sidebar" title="Toggle sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div>
            <h1 class="h5 mb-0"><?= htmlspecialchars($pageHeading) ?></h1>
            <small class="text-muted-soft">Student Course Management System</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-primary" data-action="toggle-theme">
            <i class="fa-solid fa-circle-half-stroke"></i>
            Dark Mode
        </button>
        <button class="btn btn-outline-success" data-toast="Welcome back!" data-variant="success">
            <i class="fa-solid fa-bell"></i>
        </button>
        <div class="rounded-circle bg-primary text-white d-grid place-items-center" style="width:38px;height:38px;display:grid;place-items:center;">
            S
        </div>
    </div>
</header>
