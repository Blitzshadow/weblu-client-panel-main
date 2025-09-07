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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Weblu Panel</title>
    <link rel="shortcut icon" href="/assets/dashboard/images/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900">
    <?php $plugin_url = plugin_dir_url(dirname(__FILE__)); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url; ?>assets/dashboard/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url; ?>assets/dashboard/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url; ?>assets/dashboard/css/dashboard-custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url; ?>assets/dashboard/css/semantic.css" />
</head>
<body>
<div class="wrapper">
    <!-- Preloader -->
    <div id="pre-loader">
        <img src="/assets/dashboard/images/pre-loader/loader-01.svg" alt="">
    </div>
    <!-- Header -->
    <nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-left navbar-brand-wrapper">
            <a class="navbar-brand brand-logo" href="?page=main"><img src="/assets/dashboard/images/logo-dark.png" alt="" ></a>
            <a class="navbar-brand brand-logo-mini" href="?page=main"><img src="/assets/dashboard/images/logo-icon-dark.png" alt=""></a>
        </div>
        <ul class="nav navbar-nav mr-auto">
            <li class="nav-item">
                <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item fullscreen">
                <a id="btnFullscreen" href="#" class="nav-link" ><i class="ti-fullscreen"></i></a>
            </li>
        </ul>
    </nav>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="?page=main"><img src="/assets/dashboard/images/logo-dark.png" alt="Logo" /></a>
        </div>
        <ul class="list-unstyled components">
            <li><a href="?page=main"><i class="ti-dashboard"></i> Dashboard</a></li>
            <li><a href="?page=account"><i class="ti-user"></i> Konto</a></li>
            <li><a href="?page=notifications"><i class="ti-bell"></i> Powiadomienia</a></li>
            <li><a href="?page=payments"><i class="ti-credit-card"></i> Płatności</a></li>
            <li><a href="?page=services"><i class="ti-briefcase"></i> Usługi</a></li>
            <li><a href="?page=support"><i class="ti-headphone-alt"></i> Wsparcie</a></li>
        </ul>
    </nav>
    <!-- Main Content -->
    <div class="main-content p-4">
        <?php include __DIR__ . "/panel-{$page}.php"; ?>
    </div>
</div>
</body>
</html>
