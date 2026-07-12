<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Dokter</h6>
            <a href="<?= base_url('dokter/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Dokter
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Spesialis</th>
                        <th>No. HP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dokter)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data dokter.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dokter as $i => $d): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($d['nama_dokter']) ?></td>
                                <td><span class="badge bg-info-subtle text-info-emphasis"><?= esc($d['spesialis']) ?></span></td>
                                <td><?= esc($d['no_hp'] ?? '-') ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('dokter/edit/' . $d['id_dokter']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('dokter/delete/' . $d['id_dokter']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus data dokter ini?')">
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
