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
                    <h3 class="card-title">User Management (<?= $total ?>)</h3>

                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <form method="get" action="<?= site_url('users') ?>" class="form-inline mb-3">
                            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control mr-2" placeholder="Search name/email">
                            <button class="btn btn-secondary btn-sm">Search</button>
                        </form>
                        <div>
                            <a href="<?= site_url('users/create') ?>" class="btn btn-success btn-sm justify-content-right">
                                <span class="icon">
                                    <i class="fas fa-plus"> </i>
                                </span>
                                Add User
                            </a>
                        </div>
                    </div>


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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Action</th>
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
                                        <td><?= htmlspecialchars($u->role) ?></td>
                                        <td><?= htmlspecialchars($u->created_at) ?></td>
                                        <td>
                                            <a href="<?= site_url('users/edit/' . $u->id) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <?php if ($this->session->userdata('user_id') != $u->id): ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-user-<?= $u->id ?>"><i class="fas fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk setiap user -->
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
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            </div>

            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->