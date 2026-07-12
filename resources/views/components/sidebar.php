<?php
$activePage = $activePage ?? '';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isAdminArea = str_starts_with($currentPath, '/admin');
?>
<aside class="sidebar">
    <div class="brand">
        <i class="fa-solid fa-graduation-cap fa-lg"></i>
        <span class="label"><?= $isAdminArea ? 'Admin Panel' : 'Student Panel' ?></span>
    </div>

    <?php if (! $isAdminArea): ?>
        <a class="nav-link" data-bs-toggle="collapse" href="#studentMenu" role="button" aria-expanded="true" aria-controls="studentMenu">
            <i class="fa-solid fa-user-graduate"></i><span class="label">Student Menu</span>
        </a>
        <div class="collapse show" id="studentMenu">
            <a class="nav-link <?= $activePage === 'student-dashboard' ? 'active' : '' ?>" href="/student">
                <i class="fa-solid fa-gauge"></i><span class="label">Dashboard</span>
            </a>
            <a class="nav-link <?= $activePage === 'courses' ? 'active' : '' ?>" href="/courses">
                <i class="fa-solid fa-book-open"></i><span class="label">Courses</span>
            </a>
            <a class="nav-link <?= $activePage === 'my-courses' ? 'active' : '' ?>" href="/my-courses">
                <i class="fa-solid fa-calendar-check"></i><span class="label">My Courses</span>
            </a>
            <a class="nav-link <?= $activePage === 'profile' ? 'active' : '' ?>" href="/profile">
                <i class="fa-solid fa-user-gear"></i><span class="label">Profile</span>
            </a>
        </div>
    <?php else: ?>
        <a class="nav-link" data-bs-toggle="collapse" href="#adminMenu" role="button" aria-expanded="true" aria-controls="adminMenu">
            <i class="fa-solid fa-shield-halved"></i><span class="label">Administration</span>
        </a>
        <div class="collapse show" id="adminMenu">
            <a class="nav-link <?= $activePage === 'admin-dashboard' ? 'active' : '' ?>" href="/admin">
                <i class="fa-solid fa-chart-pie"></i><span class="label">Admin Dashboard</span>
            </a>
            <a class="nav-link <?= $activePage === 'students-management' ? 'active' : '' ?>" href="/admin/students">
                <i class="fa-solid fa-users"></i><span class="label">Students</span>
            </a>
            <a class="nav-link <?= $activePage === 'courses-management' ? 'active' : '' ?>" href="/admin/courses">
                <i class="fa-solid fa-layer-group"></i><span class="label">Courses Mgmt</span>
            </a>
            <a class="nav-link <?= $activePage === 'departments-management' ? 'active' : '' ?>" href="/admin/departments">
                <i class="fa-solid fa-building"></i><span class="label">Departments</span>
            </a>
            <a class="nav-link <?= $activePage === 'course-schedule-management' ? 'active' : '' ?>" href="/admin/course-schedules">
                <i class="fa-solid fa-clipboard-list"></i><span class="label">Course Schedule</span>
            </a>
        </div>
    <?php endif; ?>

    <a class="nav-link mt-2" href="/logout">
        <i class="fa-solid fa-right-from-bracket"></i><span class="label">Logout</span>
    </a>
</aside>
