<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>


<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Edit Data Poli</h6>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('poli/update/' . $poli['id_poli']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nama Poli</label>
                <input type="text" name="nama_poli" class="form-control"
                       value="<?= old('nama_poli', $poli['nama_poli']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control"
                       value="<?= old('lokasi', $poli['lokasi']) ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Update
            </button>
            <a href="<?= base_url('poli') ?>" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<?= view('templates/footer') ?>
