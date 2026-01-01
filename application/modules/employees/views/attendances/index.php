<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Absensi Karyawan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item active">Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Data Absensi (<?= $total ?>)</h3>
                    <a href="<?= site_url('employees/attendances/create') ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Absensi
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>

                    <!-- ... bagian header tetap ... -->

                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Status</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($attendances)):
                                $i = 1;
                                foreach ($attendances as $a): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <?= htmlspecialchars(isset($a->employee_name) && $a->employee_name
                                                ? $a->employee_name
                                                : $a->employee_id) ?>
                                        </td>
                                        <td><?= htmlspecialchars($a->date) ?></td>
                                        <td><?= htmlspecialchars($a->time_in) ?></td>
                                        <td><?= htmlspecialchars($a->time_out) ?></td>
                                        <td><?= htmlspecialchars($a->status) ?></td>
                                        <td><?= htmlspecialchars($a->location) ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('employees/attendances/edit/' . $a->id) ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('employees/attendances/delete/' . $a->id) ?>"
                                                onclick="return confirm('Hapus data ini?')"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak tersedia</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>


                    <div class="mt-3"><?= $pagination ?></div>
                </div>
            </div>

        </div>
    </section>
</div>