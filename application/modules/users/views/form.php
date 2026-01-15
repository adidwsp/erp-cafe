<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $user ? 'Edit User' : 'Add User' ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" class="form-control" value="<?= set_value('name', $user ? $user->name : '') ?>" required>
                        <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" value="<?= set_value('email', $user ? $user->email : '') ?>" required>
                        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <label>Password <?= $user ? '<small>(kosong = tidak diubah)</small>' : '' ?></label>
                        <input name="password" type="password" class="form-control" <?= $user ? '' : 'required' ?>>
                        <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <?php $roles = ['owner', 'cashier', 'admin'];
                            $sel = set_value('role', $user->role); ?>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r ?>" <?= $r == $sel ? 'selected' : '' ?>><?= ucfirst($r) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('role', '<small class="text-danger">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary"><?= $user ? 'Update' : 'Create' ?></button>
                        <a href="<?= site_url('users') ?>" class="btn btn-default">Back</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>