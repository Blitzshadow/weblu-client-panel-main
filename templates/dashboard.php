<?php
// Główny dashboard z modularną strukturą
$page = isset($_GET['page']) ? $_GET['page'] : 'main';
$allowed_pages = [
    'main',
    'account',
    'notifications',
    'payments',
    'services',
    'support'
];
if (!in_array($page, $allowed_pages)) {
    $page = 'main';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weblu Panel</title>
    <link rel="stylesheet" href="/assets/dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/dashboard/css/dashboard-custom.css">
    <link rel="stylesheet" href="/assets/dashboard/css/semantic.css">
    <link rel="stylesheet" href="/assets/weblu-client-panel.css">
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="?page=main"><img src="/assets/dashboard/images/logo-dark.png" alt="Logo" /></a>
        </div>
        <ul class="list-unstyled components">
            <li><a href="?page=main">Dashboard</a></li>
            <li><a href="?page=account">Konto</a></li>
            <li><a href="?page=notifications">Powiadomienia</a></li>
            <li><a href="?page=payments">Płatności</a></li>
            <li><a href="?page=services">Usługi</a></li>
            <li><a href="?page=support">Wsparcie</a></li>
        </ul>
    </nav>
    <!-- Main Content -->
    <div class="main-content">
        <?php include __DIR__ . "/panel-{$page}.php"; ?>
    </div>
</div>
</body>
</html>
