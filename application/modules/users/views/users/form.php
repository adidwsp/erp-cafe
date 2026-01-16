<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $user ? 'Edit User' : 'Add User' ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('users.users') ?>">Users</a></li>
                        <li class="breadcrumb-item active"><?= $user ? 'Edit' : 'Create' ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pengguna</h3>
                </div>

                <div class="card-body">
                    <?= form_open('', ['class' => 'form-horizontal', 'id' => 'user-form']) ?>

                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input name="name" id="name" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>"
                            value="<?= set_value('name', $user ? $user->name : '') ?>"
                            placeholder="Masukkan nama lengkap" required>
                        <div class="invalid-feedback"><?= form_error('name') ?></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email <span class="text-danger">*</span></label>
                        <input name="email" id="email" type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>"
                            value="<?= set_value('email', $user ? $user->email : '') ?>"
                            placeholder="Masukkan alamat email" required>
                        <div class="invalid-feedback"><?= form_error('email') ?></div>
                        <small class="form-text text-muted">Email akan digunakan untuk login.</small>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <?= $user ? '<small class="text-muted">(leave blank to keep current)</small>' : '<span class="text-danger">*</span>' ?></label>
                        <input name="password" id="password" type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                            placeholder="<?= $user ? 'Masukkan password baru (min 6 karakter)' : 'Masukkan password (min 6 karakter)' ?>"
                            <?= $user ? '' : 'required' ?>>
                        <div class="invalid-feedback"><?= form_error('password') ?></div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password <?= $user ? '' : '<span class="text-danger">*</span>' ?></label>
                        <input name="confirm_password" id="confirm_password" type="password"
                            class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>"
                            placeholder="Konfirmasi password">
                        <div class="invalid-feedback"><?= form_error('confirm_password') ?></div>
                    </div>

                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control <?= form_error('role') ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Pilih Role --</option>
                            <?php
                            // Ambil daftar role dari model
                            if (isset($roles) && is_array($roles)):
                                $sel_role = set_value('role', $user ? $user->role : '');
                                foreach ($roles as $key => $value):
                            ?>
                                    <option value="<?= $key ?>" <?= $key == $sel_role ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($value) ?>
                                    </option>
                                <?php
                                endforeach;
                            else:
                                // Fallback jika $roles tidak ada
                                $default_roles = [
                                    'administrator' => 'Administrator',
                                    'owner' => 'Owner',
                                    'cashier' => 'Cashier',
                                    // 'hr_manager' => 'HR Manager',
                                    // 'sales_manager' => 'Sales Manager',
                                    // 'purchase_manager' => 'Purchase Manager',
                                    // 'inventory_manager' => 'Inventory Manager'
                                ];
                                $sel_role = set_value('role', $user ? $user->role : '');
                                foreach ($default_roles as $key => $value):
                                ?>
                                    <option value="<?= $key ?>" <?= $key == $sel_role ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($value) ?>
                                    </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <div class="invalid-feedback"><?= form_error('role') ?></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $user ? 'Update Pengguna' : 'Buat Pengguna' ?>
                        </button>
                        <a href="<?= site_url('users/users') ?>" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Kembali ke daftar
                        </a>

                        <?php if ($user): ?>
                            <a href="<?= site_url('users/change_password/' . $user->id) ?>" class="btn btn-info float-right">
                                <i class="fas fa-key"></i> Rubah Password
                            </a>
                        <?php endif; ?>
                    </div>

                    <?= form_close() ?>
                </div>

                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Kolom ditandai <span class="text-danger">*</span> harus diisi.
                    </small>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<script>
    $(document).ready(function() {
        // Password validation
        $('#user-form').on('submit', function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();

            <?php if (isset($user) && $user): ?>
                // For edit: if password is filled, confirm must match
                if (password && password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password and Confirm Password must match!');
                    $('#confirm_password').focus();
                    return false;
                }
            <?php else: ?>
                // For create: password is required and must match confirm
                if (!password) {
                    e.preventDefault();
                    alert('Password is required!');
                    $('#password').focus();
                    return false;
                }

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password and Confirm Password must match!');
                    $('#confirm_password').focus();
                    return false;
                }
            <?php endif; ?>

            // Password length validation
            if (password && password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                $('#password').focus();
                return false;
            }

            return true;
        });

        // Toggle password visibility (optional)
        $('.toggle-password').click(function() {
            var input = $('#password');
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>

<!-- Optional: Add eye icon to toggle password visibility -->
<style>
    .input-group-text.toggle-password {
        cursor: pointer;
    }

    .input-group-text.toggle-password:hover {
        background-color: #e9ecef;
    }
</style>