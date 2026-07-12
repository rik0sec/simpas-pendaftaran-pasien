<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Daftarkan Pasien Baru</h6>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($pasien)): ?>
            <div class="alert alert-warning">
                Belum ada data pasien. <a href="<?= base_url('pasien/create') ?>">Tambah pasien dulu</a> sebelum bisa mendaftarkan.
            </div>
        <?php endif; ?>

        <form action="<?= base_url('pendaftaran/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Pasien</label>
                <select name="id_pasien" class="form-select" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach ($pasien as $p): ?>
                        <option value="<?= $p['id_pasien'] ?>" <?= old('id_pasien') == $p['id_pasien'] ? 'selected' : '' ?>>
                            <?= esc($p['nama']) ?> (<?= esc($p['no_rm']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poli</label>
                    <select name="id_poli" class="form-select" required>
                        <option value="">-- Pilih Poli --</option>
                        <?php foreach ($poli as $p): ?>
                            <option value="<?= $p['id_poli'] ?>" <?= old('id_poli') == $p['id_poli'] ? 'selected' : '' ?>>
                                <?= esc($p['nama_poli']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="id_dokter" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php foreach ($dokter as $d): ?>
                            <option value="<?= $d['id_dokter'] ?>" <?= old('id_dokter') == $d['id_dokter'] ? 'selected' : '' ?>>
                                <?= esc($d['nama_dokter']) ?> (<?= esc($d['spesialis']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" class="form-control"
                       value="<?= old('tanggal_daftar', date('Y-m-d')) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keluhan</label>
                <textarea name="keluhan" class="form-control" rows="3"
                          placeholder="contoh: demam, batuk 3 hari"><?= old('keluhan') ?></textarea>
            </div>

            <div class="alert alert-info small">
                <i class="bi bi-info-circle"></i> Nomor antrian akan dibuat otomatis berdasarkan poli & tanggal yang dipilih.
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-lg"></i> Daftarkan
            </button>
            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<?= view('templates/footer') ?>
