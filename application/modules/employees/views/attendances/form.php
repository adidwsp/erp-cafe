<?php
// pastikan variabel ada
$attendance = isset($attendance) ? $attendance : null;
$employees = isset($employees) ? $employees : [];
$editing = !empty($attendance);

$is_edit = isset($attendance) && $attendance;

// default waktu sekarang
$today_date = date('Y-m-d');
$now_datetime = date('Y-m-d\TH:i');

// Tentukan action form secara eksplisit supaya tidak ambigu
$form_action = $editing && $attendance
    ? site_url('employees/attendances/edit/' . $attendance->id)
    : site_url('employees/attendances/create');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1><?= $editing ? 'Edit Absensi' : 'Tambah Absensi' ?></h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <?= form_open($form_action) ?>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Karyawan</label>
                                <?= form_dropdown(
                                    'employee_id',
                                    $employees, // ⬅️ dari tabel employees
                                    set_value('employee_id', isset($attendance) ? $attendance->employee_id : ''),
                                    'class="form-control" required'
                                ) ?>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="date" class="form-control"
                                    value="<?= set_value(
                                                'date',
                                                $is_edit && $attendance
                                                    ? $attendance->date
                                                    : $today_date
                                            ) ?>" required>
                                <?= form_error('date', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Jam Masuk</label>
                                <input type="datetime-local" name="time_in" class="form-control"
                                    value="<?= set_value(
                                                'time_in',
                                                $is_edit && !empty($attendance->time_in)
                                                    ? date('Y-m-d\TH:i', strtotime($attendance->time_in))
                                                    : $now_datetime
                                            ) ?>" required>
                                <?= form_error('time_in', '<small class="text-danger">', '</small>') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Jam Keluar</label>
                                <input type="datetime-local" name="time_out" class="form-control"
                                    value="<?= set_value(
                                                'time_out',
                                                $is_edit && !empty($attendance->time_out)
                                                    ? date('Y-m-d\TH:i', strtotime($attendance->time_out))
                                                    : $now_datetime
                                            ) ?>" required>
                                <?= form_error('time_out', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <?php
                                    $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa', 'Cuti'];
                                    foreach ($statuses as $s):
                                    ?>
                                        <option value="<?= $s ?>"
                                            <?= set_select('status', $s, $attendance && $attendance->status == $s) ?>>
                                            <?= $s ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="location" class="form-control"
                                    value="<?= set_value('location', $attendance ? $attendance->location : '') ?>" required>
                                <?= form_error('location', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        <?= $editing ? 'Perbarui' : 'Simpan' ?>
                    </button>
                    <a href="<?= site_url('employees/attendances') ?>" class="btn btn-default">Kembali</a>

                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </section>
</div>