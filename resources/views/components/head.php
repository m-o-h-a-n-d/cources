<?php
$pageTitle = $pageTitle ?? 'SCMS';
$bodyClass = $bodyClass ?? '';
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> | Student Course Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style><?php include base_path('resources/views/assets/css/tokens.css'); ?></style>
    <style><?php include base_path('resources/views/assets/css/base.css'); ?></style>
    <style><?php include base_path('resources/views/assets/css/components.css'); ?></style>
    <style><?php include base_path('resources/views/assets/css/pages.css'); ?></style>
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
