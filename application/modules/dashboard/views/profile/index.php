<!DOCTYPE html>
<html>


<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="<?= base_url('assets'); ?>/template/dist/img/user/user1-128x128.jpg"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                <?= html_escape($profile->name) ?>
                            </h3>

                            <p class="text-muted text-center">
                                <?= html_escape(
                                    ucfirst(!empty($profile->position) ? $profile->position : $profile->role)
                                ) ?>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong><i class="fas fa-id-badge mr-1"></i> NIK</strong>
                                    <a class="float-right text-muted">
                                        <?= html_escape($profile->nik ? $profile->nik : '-') ?>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-id-badge mr-1"></i> Posisi</strong>
                                    <a class="float-right text-muted">
                                        <?= html_escape($profile->position ? $profile->position : '-') ?>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-id-badge mr-1"></i> Tanggal Bergabung</strong>
                                    <a class="float-right text-muted">
                                        <?= $profile->join_date ? date('d M Y', strtotime($profile->join_date)) : '-' ?>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-id-badge mr-1"></i> Status Karyawan</strong>
                                    <a class="float-right text-muted">
                                        <?= html_escape($profile->status ? $profile->status : '-') ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>

</body>

</html>