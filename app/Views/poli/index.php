<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Poli</h6>
            <a href="<?= base_url('poli/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Poli
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Poli</th>
                        <th>Lokasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($poli)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data poli.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($poli as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($p['nama_poli']) ?></td>
                                <td><?= esc($p['lokasi'] ?? '-') ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('poli/edit/' . $p['id_poli']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('poli/delete/' . $p['id_poli']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus data poli ini?')">
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
