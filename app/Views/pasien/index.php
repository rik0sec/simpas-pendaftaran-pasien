<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Pasien</h6>
            <a href="<?= base_url('pasien/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Pasien
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No. HP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pasien)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data pasien.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pasien as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><span class="badge bg-secondary"><?= esc($p['no_rm']) ?></span></td>
                                <td><?= esc($p['nik']) ?></td>
                                <td><?= esc($p['nama']) ?></td>
                                <td><?= $p['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td><?= date('d-m-Y', strtotime($p['tanggal_lahir'])) ?></td>
                                <td><?= esc($p['no_hp'] ?? '-') ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('pasien/edit/' . $p['id_pasien']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('pasien/delete/' . $p['id_pasien']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus data pasien ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>
