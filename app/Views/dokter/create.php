<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Tambah Dokter Baru</h6>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('dokter/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nama Dokter</label>
                <input type="text" name="nama_dokter" class="form-control"
                       value="<?= old('nama_dokter') ?>" placeholder="contoh: dr. Andi Wijaya" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Spesialis</label>
                <input type="text" name="spesialis" class="form-control"
                       value="<?= old('spesialis') ?>" placeholder="contoh: Umum, Gigi, Anak" required>
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" maxlength="15"
                       value="<?= old('no_hp') ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Simpan
            </button>
            <a href="<?= base_url('dokter') ?>" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<?= view('templates/footer') ?>
