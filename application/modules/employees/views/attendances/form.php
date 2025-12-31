<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1><?= isset($attendance) ? 'Edit Absensi' : 'Tambah Absensi' ?></h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <?= form_open() ?>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Employee ID</label>
                                <input type="text" name="employee_id" class="form-control"
                                    value="<?= set_value('employee_id', $attendance->employee_id) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="date" class="form-control"
                                    value="<?= set_value('date', $attendance->date) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Jam Masuk</label>
                                <input type="datetime-local" name="time_in" class="form-control"
                                    value="<?= set_value(
                                                'time_in',
                                                isset($attendance)
                                                    ? date('Y-m-d\TH:i', strtotime($attendance->time_in))
                                                    : ''
                                            ) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Jam Keluar</label>
                                <input type="datetime-local" name="time_out" class="form-control"
                                    value="<?= set_value(
                                                'time_out',
                                                isset($attendance)
                                                    ? date('Y-m-d\TH:i', strtotime($attendance->time_out))
                                                    : ''
                                            ) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <?php
                                    $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa', 'Cuti'];
                                    foreach ($statuses as $s):
                                    ?>
                                        <option value="<?= $s ?>"
                                            <?= set_select('status', $s, isset($attendance) && $attendance->status == $s) ?>>
                                            <?= $s ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="location" class="form-control"
                                    value="<?= set_value('location', $attendance->location) ?>" required>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        <?= isset($attendance) ? 'Perbarui' : 'Simpan' ?>
                    </button>
                    <a href="<?= site_url('employees/attendances') ?>" class="btn btn-default">Kembali</a>

                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </section>
</div>