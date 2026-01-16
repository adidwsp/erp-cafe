<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $role ? 'Edit Role' : 'Tambah Role Baru' ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('users/roles') ?>">Role</a></li>
                        <li class="breadcrumb-item active"><?= $role ? 'Edit' : 'Tambah' ?></li>
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
                    <h3 class="card-title">Informasi Role</h3>
                </div>

                <div class="card-body">
                    <?= form_open('', ['class' => 'form-horizontal', 'id' => 'role-form']) ?>

                    <!-- Role Name -->
                    <div class="form-group">
                        <label for="role_name">Kode Role <span class="text-danger">*</span></label>
                        <?php if ($role): ?>
                            <!-- Edit mode: show readonly -->
                            <input type="text" class="form-control" value="<?= htmlspecialchars($role->role_name) ?>" readonly>
                            <input type="hidden" name="role_name" value="<?= htmlspecialchars($role->role_name) ?>">
                            <small class="form-text text-muted">Kode role tidak dapat diubah.</small>
                        <?php else: ?>
                            <!-- Create mode: editable -->
                            <input name="role_name" id="role_name" class="form-control <?= form_error('role_name') ? 'is-invalid' : '' ?>"
                                value="<?= set_value('role_name') ?>"
                                placeholder="Contoh: sales_manager, hr_supervisor" required>
                            <div class="invalid-feedback"><?= form_error('role_name') ?></div>
                            <small class="form-text text-muted">Gunakan huruf kecil dan underscore (contoh: sales_manager).</small>
                        <?php endif; ?>
                    </div>

                    <!-- Display Name -->
                    <div class="form-group">
                        <label for="display_name">Nama Tampilan <span class="text-danger">*</span></label>
                        <input name="display_name" id="display_name" class="form-control <?= form_error('display_name') ? 'is-invalid' : '' ?>"
                            value="<?= set_value('display_name', $role ? $role->display_name : '') ?>"
                            placeholder="Contoh: Manager Penjualan, Supervisor HR" required>
                        <div class="invalid-feedback"><?= form_error('display_name') ?></div>
                        <small class="form-text text-muted">Nama yang akan ditampilkan di sistem.</small>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>"
                            rows="3" placeholder="Deskripsi singkat tentang role ini"><?= set_value('description', $role ? $role->description : '') ?></textarea>
                        <div class="invalid-feedback"><?= form_error('description') ?></div>
                    </div>

                    <!-- Permissions Section -->
                    <div class="form-group">
                        <label>Hak Akses <span class="text-danger">*</span></label>
                        <div class="alert alert-info">
                            <i class="icon fas fa-info"></i> Centang hak akses yang diizinkan untuk role ini.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="30%">Modul</th>
                                        <th class="text-center">Lihat</th>
                                        <th class="text-center">Tambah</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Hapus</th>
                                        <th class="text-center">Semua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $modules = [
                                        'dashboard' => 'Dashboard',
                                        'hr' => 'Human Resources',
                                        'sales' => 'Penjualan',
                                        'purchasing' => 'Pembelian',
                                        'inventory' => 'Inventori',
                                        'users' => 'Manajemen User',
                                        'reports' => 'Laporan'
                                    ];

                                    $permissions_data = [];
                                    if ($role && isset($permissions)) {
                                        foreach ($permissions as $perm) {
                                            $permissions_data[$perm->module] = [
                                                'view' => $perm->can_view,
                                                'create' => $perm->can_create,
                                                'edit' => $perm->can_edit,
                                                'delete' => $perm->can_delete
                                            ];
                                        }
                                    }

                                    foreach ($modules as $key => $name):
                                        $checked_view = isset($permissions_data[$key]['view']) && $permissions_data[$key]['view'] ? 'checked' : '';
                                        $checked_create = isset($permissions_data[$key]['create']) && $permissions_data[$key]['create'] ? 'checked' : '';
                                        $checked_edit = isset($permissions_data[$key]['edit']) && $permissions_data[$key]['edit'] ? 'checked' : '';
                                        $checked_delete = isset($permissions_data[$key]['delete']) && $permissions_data[$key]['delete'] ? 'checked' : '';
                                    ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($name) ?></strong>
                                                <input type="hidden" name="modules[<?= $key ?>][view]" value="0">
                                                <input type="hidden" name="modules[<?= $key ?>][create]" value="0">
                                                <input type="hidden" name="modules[<?= $key ?>][edit]" value="0">
                                                <input type="hidden" name="modules[<?= $key ?>][delete]" value="0">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox"
                                                        type="checkbox"
                                                        name="modules[<?= $key ?>][view]"
                                                        value="1"
                                                        data-module="<?= $key ?>"
                                                        <?= $checked_view ?>>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox"
                                                        type="checkbox"
                                                        name="modules[<?= $key ?>][create]"
                                                        value="1"
                                                        data-module="<?= $key ?>"
                                                        <?= $checked_create ?>>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox"
                                                        type="checkbox"
                                                        name="modules[<?= $key ?>][edit]"
                                                        value="1"
                                                        data-module="<?= $key ?>"
                                                        <?= $checked_edit ?>>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox"
                                                        type="checkbox"
                                                        name="modules[<?= $key ?>][delete]"
                                                        value="1"
                                                        data-module="<?= $key ?>"
                                                        <?= $checked_delete ?>>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input select-all-module"
                                                        type="checkbox"
                                                        data-module="<?= $key ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong>Pilih Semua</strong></td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input select-all-action"
                                                    type="checkbox"
                                                    data-action="view">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input select-all-action"
                                                    type="checkbox"
                                                    data-action="create">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input select-all-action"
                                                    type="checkbox"
                                                    data-action="edit">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input select-all-action"
                                                    type="checkbox"
                                                    data-action="delete">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input select-all-global"
                                                    type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $role ? 'Update Role' : 'Simpan Role' ?>
                        </button>
                        <a href="<?= site_url('users/roles') ?>" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>

                        <?php if ($role && !in_array($role->role_name, ['administrator', 'owner'])): ?>
                            <a href="<?= site_url('users/roles/delete/' . $role->id) ?>"
                                class="btn btn-danger float-right"
                                onclick="return confirm('Yakin menghapus role ini?')">
                                <i class="fas fa-trash"></i> Hapus Role
                            </a>
                        <?php endif; ?>
                    </div>

                    <?= form_close() ?>
                </div>

                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Field dengan tanda <span class="text-danger">*</span> wajib diisi.
                    </small>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<style>
    .permission-checkbox {
        transform: scale(1.2);
    }

    .select-all-module,
    .select-all-action,
    .select-all-global {
        transform: scale(1.2);
    }

    .table th {
        background-color: #f8f9fa;
    }
</style>

<script>
    $(document).ready(function() {
        // Validasi form
        $('#role-form').on('submit', function(e) {
            var roleName = $('#role_name').val();
            var displayName = $('#display_name').val();

            if (!roleName && !$('[name="role_name"][type="hidden"]').length) {
                e.preventDefault();
                alert('Kode Role wajib diisi!');
                $('#role_name').focus();
                return false;
            }

            if (!displayName) {
                e.preventDefault();
                alert('Nama Tampilan wajib diisi!');
                $('#display_name').focus();
                return false;
            }

            // Cek minimal satu permission terpilih
            var hasPermission = false;
            $('.permission-checkbox:checked').each(function() {
                hasPermission = true;
                return false; // break loop
            });

            if (!hasPermission) {
                e.preventDefault();
                alert('Pilih minimal satu hak akses!');
                return false;
            }

            return true;
        });

        // Select all for a specific module
        $('.select-all-module').click(function() {
            var module = $(this).data('module');
            var isChecked = $(this).is(':checked');

            $('.permission-checkbox[data-module="' + module + '"]').prop('checked', isChecked);
        });

        // Select all for a specific action across all modules
        $('.select-all-action').click(function() {
            var action = $(this).data('action');
            var isChecked = $(this).is(':checked');

            $('input[name*="[' + action + ']"]').not('.select-all-action').prop('checked', isChecked);
        });

        // Select all globally
        $('.select-all-global').click(function() {
            var isChecked = $(this).is(':checked');

            $('.permission-checkbox').prop('checked', isChecked);
            $('.select-all-module').prop('checked', isChecked);
            $('.select-all-action').prop('checked', isChecked);
        });

        // Update "Select All Module" checkbox when individual checkboxes change
        $('.permission-checkbox').change(function() {
            var module = $(this).data('module');
            var allChecked = true;

            $('.permission-checkbox[data-module="' + module + '"]').each(function() {
                if (!$(this).is(':checked')) {
                    allChecked = false;
                    return false; // break loop
                }
            });

            $('.select-all-module[data-module="' + module + '"]').prop('checked', allChecked);
        });

        // Update "Select All Action" checkbox when individual checkboxes change
        $('.permission-checkbox').change(function() {
            var name = $(this).attr('name');
            var action = name.match(/\[(.*?)\]/)[1]; // Extract action from name
            var allChecked = true;

            $('input[name*="[' + action + ']"]').not('.select-all-action').each(function() {
                if (!$(this).is(':checked')) {
                    allChecked = false;
                    return false; // break loop
                }
            });

            $('.select-all-action[data-action="' + action + '"]').prop('checked', allChecked);
        });

        // Auto-check "Select All Global" when all checkboxes are checked
        $('.permission-checkbox').change(function() {
            var allChecked = true;

            $('.permission-checkbox').each(function() {
                if (!$(this).is(':checked')) {
                    allChecked = false;
                    return false; // break loop
                }
            });

            $('.select-all-global').prop('checked', allChecked);
        });

        // Quick templates for common roles
        $('#quick-template').change(function() {
            var template = $(this).val();
            if (!template) return;

            // Reset all checkboxes
            $('.permission-checkbox').prop('checked', false);

            // Apply template
            switch (template) {
                case 'administrator':
                    $('.permission-checkbox').prop('checked', true);
                    break;
                case 'cashier':
                    $('input[name*="[dashboard]"]').prop('checked', true);
                    $('input[name*="[sales]"]').prop('checked', true);
                    $('input[name*="[inventory]"]').prop('checked', true);
                    $('input[name*="[reports]"]').prop('checked', true);
                    // Cashier can view inventory but not modify
                    $('input[name*="[inventory][create]"]').prop('checked', false);
                    $('input[name*="[inventory][edit]"]').prop('checked', false);
                    $('input[name*="[inventory][delete]"]').prop('checked', false);
                    break;
                case 'hr_manager':
                    $('input[name*="[dashboard]"]').prop('checked', true);
                    $('input[name*="[hr]"]').prop('checked', true);
                    $('input[name*="[reports]"]').prop('checked', true);
                    break;
            }

            // Update all select-all checkboxes
            $('.permission-checkbox').trigger('change');
        });
    });
</script>

<!-- Optional: Quick Template Selector (uncomment if needed) -->
<!--
<div class="form-group">
    <label for="quick-template">Template Cepat</label>
    <select id="quick-template" class="form-control">
        <option value="">-- Pilih Template --</option>
        <option value="administrator">Administrator (Semua Akses)</option>
        <option value="cashier">Kasir (Dashboard, Penjualan, Inventori)</option>
        <option value="hr_manager">Manager HR (Dashboard, HR, Laporan)</option>
        <option value="sales_manager">Manager Penjualan (Dashboard, Penjualan, Inventori)</option>
        <option value="purchase_manager">Manager Pembelian (Dashboard, Pembelian, Inventori)</option>
    </select>
    <small class="form-text text-muted">Pilih template untuk mengisi hak akses secara otomatis.</small>
</div>
-->