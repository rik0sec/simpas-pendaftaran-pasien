<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Pendaftaran Pasien</h6>
            <a href="<?= base_url('pendaftaran/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Daftarkan Pasien
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No. Antrian</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendaftaran)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada data pendaftaran.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pendaftaran as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><span class="badge bg-primary"><?= $row['no_antrian'] ?></span></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_daftar'])) ?></td>
                                <td>
                                    <?= esc($row['nama_pasien']) ?>
                                    <div class="text-muted small"><?= esc($row['no_rm']) ?></div>
                                </td>
                                <td><?= esc($row['nama_dokter']) ?></td>
                                <td><?= esc($row['nama_poli']) ?></td>
                                <td><?= esc($row['keluhan'] ?? '-') ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Selesai'): ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('pendaftaran/edit/' . $row['id_daftar']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('pendaftaran/delete/' . $row['id_daftar']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus data pendaftaran ini?')">
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
