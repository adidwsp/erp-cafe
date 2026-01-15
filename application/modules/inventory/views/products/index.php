<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Produk (<?= $total ?>)</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <form method="get" action="<?= base_url('inventory/products') ?>" class="form-inline">
                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control mr-2" placeholder="Cari nama/SKU">
                    <button class="btn btn-secondary btn-sm">Cari</button>
                </form>
                <a href="<?= site_url('inventory/products/create') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>

            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Nama</th>
                            <th>Unit</th>
                            <th>Min</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): $i = ((int)$this->input->get('page') + 1);
                            foreach ($products as $p): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($p->sku) ?></td>
                                    <td><?= htmlspecialchars($p->name) ?></td>
                                    <td><?= htmlspecialchars($p->unit) ?></td>
                                    <td><?= htmlspecialchars($p->min_stock) ?></td>
                                    <td>
                                        <a href="<?= site_url('inventory/products/edit/' . $p->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="<?= site_url('inventory/products/delete/' . $p->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Data tidak tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-3"><?= $pagination ?></div>
            </div>
        </div>
    </section>
</div>