<div class="content-wrapper">
    <section class="content-header">
        <h1><?= isset($product) ? 'Edit Produk' : 'Tambah Produk' ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?= form_open() ?>
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control" value="<?= isset($product) ? $product->sku : '' ?>" required>
                    <?= form_error('sku', '<small class="text-danger">', '</small>') ?>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= isset($product) ? $product->name : '' ?>" required>
                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                </div>

                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" name="unit" class="form-control" value="<?= isset($product) ? $product->unit : 'pcs' ?>" required>
                </div>

                <div class="form-group">
                    <label>Min Stock</label>
                    <input type="number" name="min_stock" class="form-control" value="<?= isset($product) ? $product->min_stock : 0 ?>" required>
                </div>

                <button class="btn btn-primary"><?= isset($product) ? 'Perbarui' : 'Simpan' ?></button>
                <a href="<?= site_url('inventory/products') ?>" class="btn btn-default">Kembali</a>
                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>