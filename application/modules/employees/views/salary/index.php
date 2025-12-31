<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payroll Bulanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item active">Payroll</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Payroll Bulanan (<?= isset($total) ? $total : count($salaries) ?>)</h3>
                    <div>
                        <!-- Trigger modal confirm generate -->
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#confirmGenerate">
                            <i class="fas fa-cogs"></i> Generate Gaji
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>

                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Gaji Pokok</th>
                                <th>Lembur</th>
                                <th>Potongan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($salaries)):
                                $no = 1;
                                foreach ($salaries as $s): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($s->nik) ?></td>
                                        <td><?= htmlspecialchars($s->name) ?></td>
                                        <td class="text-right"><?= number_format($s->base_salary, 0, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format($s->overtime_pay, 0, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format($s->deduction, 0, ',', '.') ?></td>
                                        <td class="text-right"><strong><?= number_format($s->total_salary, 0, ',', '.') ?></strong></td>
                                        <td class="text-center">
                                            <?php if ($s->status === 'draft'): ?>
                                                <span class="badge badge-warning">Draft</span>
                                            <?php elseif ($s->status === 'approved'): ?>
                                                <span class="badge badge-primary">Approved</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Paid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= site_url('employees/salary/slip/' . $s->id) ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-file-invoice-dollar"></i> Slip
                                            </a>
                                            <?php if ($s->status === 'draft'): ?>
                                                <a href="<?= site_url('employees/salary/approve/' . $s->id) ?>" class="btn btn-sm btn-success" onclick="return confirm('Approve gaji ini?')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No payroll data found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php if (isset($pagination)): ?>
                        <div class="mt-3"><?= $pagination ?></div>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Confirm Generate -->
<div class="modal fade" id="confirmGenerate" tabindex="-1" role="dialog" aria-labelledby="confirmGenerateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Gaji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Generate gaji untuk periode <strong><?= date('F Y') ?></strong> ?</p>
                <p>Proses ini akan membuat record gaji untuk seluruh karyawan yang belum digenerate.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                <a href="<?= site_url('employees/salary/generate') ?>" class="btn btn-success btn-sm">Ya, Generate</a>
            </div>
        </div>
    </div>
</div>