<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pengguna</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Simple AdminLTE table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Manajemen Pengguna (<?= $total ?>)</h3>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">
                        <form method="get" action="<?= site_url('users') ?>" class="form-inline mb-3">
                            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control mr-2" placeholder="Cari nama/email">
                            <button class="btn btn-secondary btn-sm">Cari</button>
                        </form>


                        <div>
                            <a href="<?= site_url('users/create') ?>" class="btn btn-success btn-sm justify-content-right">
                                <span class="icon">
                                    <i class="fas fa-plus"> </i>
                                </span>
                                Tambah Pengguna
                            </a>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users):
                                $page = (int)$this->input->get('page') ?: 1;
                                $i = 1 + ($page - 1) * 10;
                                foreach ($users as $u): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($u->name) ?></td>
                                        <td><?= htmlspecialchars($u->email) ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?= get_user_role_name($u->role) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($u->created_at)) ?></td>
                                        <td>
                                            <!-- Tombol Edit hanya untuk admin/owner -->

                                            <a href="<?= site_url('users/edit/' . $u->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>


                                            <!-- Tombol Delete hanya untuk admin/owner dan bukan diri sendiri -->

                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-user-<?= $u->id ?>" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>


                                            <!-- Tombol non-aktif/aktif hanya untuk admin/owner dan bukan diri sendiri -->
                                            <!-- <?php //if (is_admin_or_owner() && $this->session->userdata('id') != $u->id): 
                                                    ?> -->
                                            <!-- <?php //if (isset($u->is_active) && $u->is_active == 1): 
                                                    ?>
                                                    <a href="<?= site_url('users/toggle_status/' . $u->id) ?>" class="btn btn-sm btn-secondary" title="Deactivate" onclick="return confirm('Nonaktifkan user ini?')">
                                                        <i class="fas fa-user-times"></i>
                                                    </a>
                                                <?php //else: 
                                                ?>
                                                    <a href="<?= site_url('users/toggle_status/' . $u->id) ?>" class="btn btn-sm btn-success" title="Activate" onclick="return confirm('Aktifkan user ini?')">
                                                        <i class="fas fa-user-check"></i>
                                                    </a>
                                                <?php //endif; 
                                                ?> -->
                                            <!-- <?php //endif; 
                                                    ?> -->
                                        </td>
                                    </tr>

                                    <!-- Modal untuk setiap user (hanya admin/owner) -->

                                    <div class="modal fade" id="delete-user-<?= $u->id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete User</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure to delete <b><?= htmlspecialchars($u->name) ?></b> ?</p>
                                                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <a class="btn btn-danger" href="<?= site_url('users/delete/' . $u->id) ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="mt-3"><?= $pagination ?></div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        Menampilkan <?= count($users) ?> dari <?= $total ?> pengguna
                        <?php if ($search): ?>
                            untuk "<?= htmlspecialchars($search) ?>"
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Tambahkan ini di bagian head atau sebelum </body> -->
<script>
    // Auto-hide flash messages setelah 5 detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Confirmation untuk semua tombol delete/hapus
    $(document).on('click', '.btn-delete', function(e) {
        if (!confirm('Are you sure you want to delete this user?')) {
            e.preventDefault();
            return false;
        }
    });
</script>