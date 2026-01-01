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
                <!-- <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Data Absensi (<?= $total ?>)</h3>
                    <a href="<?= site_url('employees/attendances/create') ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Absensi
                    </a>
                </div> -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Absensi</h3>

                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <form method="get" action="<?php base_url('employees/attendances') ?>" class="form-inline mb-3">
                            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control mr-2" placeholder="Cari nama/NIK">
                            <button class="btn btn-secondary btn-sm">Cari</button>
                        </form>
                        <div>
                            <a href="<?= site_url('employees/attendances/create') ?>" class="btn btn-success btn-sm justify-content-right">
                                <span class="icon">
                                    <i class="fas fa-plus"> </i>
                                </span>
                                Tambah Absensi
                            </a>
                        </div>
                    </div>

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
                                $page = (int)$this->input->get('page') ?: 1;
                                $i = 1 + ($page - 1) * 10;
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
                                            <!-- <a href="<?= site_url('employees/attendances/delete/' . $a->id) ?>"
                                                onclick="return confirm('Hapus data ini?')"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a> -->
                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#modalDelete<?= $a->id ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <div class="modal fade" id="modalDelete<?= $a->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>
                                                            Yakin ingin menghapus absensi
                                                            <strong><?= htmlspecialchars($a->employee_name) ?></strong>
                                                            tanggal <strong><?= htmlspecialchars($a->date) ?></strong>?
                                                        </p>
                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <a href="<?= site_url('employees/attendances/delete/' . $a->id) ?>"
                                                            class="btn btn-danger">
                                                            Ya, Hapus
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

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
                    <!-- </div> -->
                </div>

            </div>
    </section>
</div>