<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $employee ? 'Edit Karyawan' : 'Tambah Karyawan' ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= form_open('', ['class' => 'form-horizontal']) ?>
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="name" class="form-control" value="<?= set_value('name', $employee ? $employee->name : '') ?>" required>
                                <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>NIK</label>
                                <input name="nik" type="text" class="form-control" value="<?= set_value('nik', $employee ? $employee->nik : '') ?>" required>
                                <?= form_error('nik', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Posisi</label>
                                <input name="position" type="position" class="form-control" value="<?= set_value('position', $employee ? $employee->position : '') ?>" required>
                                <?= form_error('position', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Bergabung</label>
                                <input name="join_date" type="date" class="form-control" value="<?= set_value('join_date', $employee ? $employee->join_date : '') ?>" required>
                                <?= form_error('join_date', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Gaji Pokok</label>
                                <input name="salary_base" type="number" class="form-control" value="<?= set_value('salary_base', $employee ? $employee->salary_base : '') ?>" required>
                                <?= form_error('salary_base', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Aktif" <?= set_select('status', 'Aktif', $employee && $employee->status == 'Aktif') ?>>Aktif</option>
                                    <option value="Non Aktif" <?= set_select('status', 'Non Aktif', $employee && $employee->status == 'Non Aktif') ?>>Non Aktif</option>
                                </select>
                                <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"><?= $employee ? 'Perbarui' : 'Buat' ?></button>
                        <a href="<?= base_url('employees/employees') ?>" class="btn btn-default">Kembali</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>