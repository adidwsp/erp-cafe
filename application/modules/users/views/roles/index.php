<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Role Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Role (<?= $total ?>)</h3>
                    <div class="card-tools">
                        <a href="<?= site_url('users/roles/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Role
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="get" action="<?= site_url('users/roles') ?>" class="form-inline">
                                <div class="input-group">
                                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>"
                                        class="form-control" placeholder="Cari role...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Nama Role</th>
                                <th>Nama Tampilan</th>
                                <th>Deskripsi</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($roles):
                                $no = 1 + (($this->input->get('page', true) ?: 1) - 1) * 10;
                                foreach ($roles as $role): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($role->role_name) ?></strong>
                                            <?php if (in_array($role->role_name, ['administrator', 'owner'])): ?>
                                                <span class="badge badge-info ml-1">System</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($role->display_name) ?></td>
                                        <td><?= htmlspecialchars($role->description) ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('users/roles/view/' . $role->id) ?>" class="btn btn-info btn-sm" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('users/roles/edit/' . $role->id) ?>" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (!in_array($role->role_name, ['administrator', 'owner'])): ?>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal<?= $role->id ?>" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <?php if (!in_array($role->role_name, ['administrator', 'owner'])): ?>
                                        <div class="modal fade" id="deleteModal<?= $role->id ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus role <strong><?= htmlspecialchars($role->display_name) ?></strong>?</p>
                                                        <p class="text-danger"><small>Aksi ini tidak dapat dibatalkan.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <a href="<?= site_url('users/roles/delete/' . $role->id) ?>" class="btn btn-danger">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data role.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="mt-3"><?= $pagination ?></div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Role dengan badge <span class="badge badge-info">System</span> tidak dapat dihapus.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>