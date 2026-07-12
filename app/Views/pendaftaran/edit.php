<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Edit Data Pendaftaran</h6>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">No. Antrian</label>
            <input type="text" class="form-control" value="<?= esc($pendaftaran['no_antrian']) ?>" disabled>
        </div>

        <form action="<?= base_url('pendaftaran/update/' . $pendaftaran['id_daftar']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Pasien</label>
                <select name="id_pasien" class="form-select" required>
                    <?php foreach ($pasien as $p): ?>
                        <option value="<?= $p['id_pasien'] ?>" <?= $pendaftaran['id_pasien'] == $p['id_pasien'] ? 'selected' : '' ?>>
                            <?= esc($p['nama']) ?> (<?= esc($p['no_rm']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poli</label>
                    <select name="id_poli" class="form-select" required>
                        <?php foreach ($poli as $p): ?>
                            <option value="<?= $p['id_poli'] ?>" <?= $pendaftaran['id_poli'] == $p['id_poli'] ? 'selected' : '' ?>>
                                <?= esc($p['nama_poli']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="id_dokter" class="form-select" required>
                        <?php foreach ($dokter as $d): ?>
                            <option value="<?= $d['id_dokter'] ?>" <?= $pendaftaran['id_dokter'] == $d['id_dokter'] ? 'selected' : '' ?>>
                                <?= esc($d['nama_dokter']) ?> (<?= esc($d['spesialis']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" class="form-control"
                           value="<?= esc($pendaftaran['tanggal_daftar']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Menunggu" <?= $pendaftaran['status'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Selesai" <?= $pendaftaran['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keluhan</label>
                <textarea name="keluhan" class="form-control" rows="3"><?= esc($pendaftaran['keluhan']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Update
            </button>
            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<?= view('templates/footer') ?>
