<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin ERP | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/template/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img
                            src="<?= base_url('assets/template/dist/img/user/user2-160x160.jpg') ?>"
                            class="user-image img-circle elevation-2"
                            alt="User Image">
                        <span class="d-none d-md-inline">
                            <?= html_escape($this->session->userdata('name')) ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img
                                src="<?= base_url('assets/template/dist/img/user/user2-160x160.jpg') ?>"
                                class="img-circle elevation-2"
                                alt="User Image">

                            <p>
                                <?= html_escape($this->session->userdata('name')) ?>
                                <small><?= html_escape($this->session->userdata('email')) ?></small>
                            </p>
                        </li>

                        <!-- Menu Footer -->
                        <li class="user-footer">
                            <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-default btn-flat">
                                <i class="fas fa-user"></i> Profil
                            </a>

                            <?= form_open('auth/logout', ['class' => 'float-right']) ?>
                            <button type="submit" class="btn btn-danger btn-flat"
                                onclick="return confirm('Logout sekarang?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                            <?= form_close() ?>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->