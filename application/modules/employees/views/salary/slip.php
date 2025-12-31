<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slip Gaji</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('employees/salary') ?>">Payroll</a></li>
                        <li class="breadcrumb-item active">Slip Gaji</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Slip Gaji - <?= htmlspecialchars($slip->name) ?></h3>
                    <div>
                        <a href="<?= site_url('employees/salary') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        <button class="btn btn-primary btn-sm" onclick="window.print()">Cetak</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>NIK</th>
                                    <td><?= htmlspecialchars($slip->nik) ?></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td><?= htmlspecialchars($slip->name) ?></td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td><?= htmlspecialchars($slip->position) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-right">
                            <strong>Periode:</strong><br>
                            <?= htmlspecialchars($slip->period_month) ?>/<?= htmlspecialchars($slip->period_year) ?><br>
                            <small>Generated at: <?= htmlspecialchars($slip->generated_at) ?></small>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>Gaji Pokok</th>
                            <td class="text-right"><?= number_format($slip->base_salary, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Lembur</th>
                            <td class="text-right"><?= number_format($slip->overtime_pay, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Potongan</th>
                            <td class="text-right"><?= number_format($slip->deduction, 0, ',', '.') ?></td>
                        </tr>
                        <tr class="table-success">
                            <th>Total Diterima</th>
                            <td class="text-right"><strong><?= number_format($slip->total_salary, 0, ',', '.') ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
</div>