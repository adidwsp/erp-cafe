<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Role: <?= htmlspecialchars($role->display_name) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('users/roles') ?>">Roles</a></li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($role->display_name) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Informasi Role -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Role</h3>
                            <div class="card-tools">
                                <a href="<?= site_url('users/roles/edit/' . $role->id) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Kode Role</th>
                                    <td>
                                        <code><?= htmlspecialchars($role->role_name) ?></code>
                                        <?php if (in_array($role->role_name, ['administrator', 'owner'])): ?>
                                            <span class="badge badge-info ml-2">System Role</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Tampilan</th>
                                    <td><?= htmlspecialchars($role->display_name) ?></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td><?= nl2br(htmlspecialchars($role->description ?: '-')) ?></td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td><?= date('d/m/Y H:i', strtotime($role->created_at)) ?></td>
                                </tr>
                                <tr>
                                    <th>Total Hak Akses</th>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= count($permissions) ?> Modul
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="<?= site_url('users/roles') ?>" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>

                                <?php if (!in_array($role->role_name, ['administrator', 'owner'])): ?>
                                    <a href="<?= site_url('users/roles/delete/' . $role->id) ?>"
                                        class="btn btn-danger float-right"
                                        onclick="return confirm('Yakin menghapus role ini?')">
                                        <i class="fas fa-trash"></i> Hapus Role
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Permissions -->
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Hak Akses</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Modul</th>
                                            <th class="text-center">Lihat</th>
                                            <th class="text-center">Tambah</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Buat array permissions untuk mudah diakses
                                        $permissions_array = [];
                                        foreach ($permissions as $perm) {
                                            $permissions_array[$perm->module] = $perm;
                                        }

                                        // Daftar modul
                                        $modules_list = [
                                            'dashboard' => 'Dashboard',
                                            'hr' => 'Human Resources',
                                            'sales' => 'Sales',
                                            'purchasing' => 'Purchasing',
                                            'inventory' => 'Inventory',
                                            'users' => 'User Management',
                                            'reports' => 'Laporan'
                                        ];

                                        foreach ($modules_list as $module_key => $module_name):
                                            $perm = isset($permissions_array[$module_key]) ? $permissions_array[$module_key] : null;
                                        ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($module_name) ?></strong>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($perm && $perm->can_view): ?>
                                                        <span class="badge badge-success">Ya</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Tidak</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($perm && $perm->can_create): ?>
                                                        <span class="badge badge-success">Ya</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Tidak</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($perm && $perm->can_edit): ?>
                                                        <span class="badge badge-success">Ya</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Tidak</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($perm && $perm->can_delete): ?>
                                                        <span class="badge badge-success">Ya</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Tidak</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (empty($permissions)): ?>
                                <div class="alert alert-warning m-3">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    Role ini belum memiliki hak akses.
                                    <a href="<?= site_url('users/roles/edit/' . $role->id) ?>">Edit role</a> untuk menambahkan hak akses.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Hak akses menentukan modul apa yang bisa diakses oleh user dengan role ini.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar User dengan Role Ini (Opsional) -->
            <?php
            // Cek apakah ada user dengan role ini
            $users_with_role = $this->db->where('role', $role->role_name)
                ->get('users')
                ->result();

            if ($users_with_role):
            ?>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">User dengan Role Ini (<?= count($users_with_role) ?>)</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Tanggal Bergabung</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($users_with_role as $user): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($user->name) ?></td>
                                                    <td><?= htmlspecialchars($user->email) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                                                    <td>
                                                        <a href="<?= site_url('users/edit/' . $user->id) ?>"
                                                            class="btn btn-xs btn-info" title="Lihat User">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">
                                    Total <?= count($users_with_role) ?> user menggunakan role ini.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Modal untuk hapus role -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Role</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus role <strong><?= htmlspecialchars($role->display_name) ?></strong>?</p>

                <?php if ($users_with_role && count($users_with_role) > 0): ?>
                    <div class="alert alert-warning">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        <strong>Peringatan!</strong> Role ini sedang digunakan oleh <?= count($users_with_role) ?> user.
                        Jika dihapus, user tersebut akan kehilangan role mereka.
                    </div>
                <?php endif; ?>

                <p class="text-danger"><small>Aksi ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="<?= site_url('users/roles/delete/' . $role->id) ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Update modal delete link jika tombol delete diklik
        $('.btn-delete-role').click(function(e) {
            e.preventDefault();
            $('#deleteRoleModal').modal('show');
        });

        // Tooltip
        $('[title]').tooltip();
    });
</script>

<style>
    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }

    .table th {
        background-color: #f8f9fa;
    }
</style>