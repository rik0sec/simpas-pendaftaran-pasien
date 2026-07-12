<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="page-heading no-print">
  <div>
    <h2>Laporan Pendaftaran</h2>
    <p class="text-muted mb-0">Rekap data pendaftaran pasien berdasarkan periode</p>
  </div>
  <div class="d-flex gap-2">
    <button class="btn-action bg-blue" onclick="window.print()">
      <i class="bi bi-printer"></i> Cetak / PDF
    </button>
  </div>
</div>

<!-- ============ FILTER ============ -->
<div class="card-panel mb-4 no-print">
  <form method="get" class="row g-3 align-items-end">
    <div class="col-6 col-md-3">
      <label class="form-label fw-semibold" style="font-size:13px;">Dari Tanggal</label>
      <input type="date" name="mulai" class="form-control" value="<?= esc($tanggalMulai) ?>">
    </div>
    <div class="col-6 col-md-3">
      <label class="form-label fw-semibold" style="font-size:13px;">Sampai Tanggal</label>
      <input type="date" name="akhir" class="form-control" value="<?= esc($tanggalAkhir) ?>">
    </div>
    <div class="col-6 col-md-3">
      <label class="form-label fw-semibold" style="font-size:13px;">Poli</label>
      <select name="poli" class="form-select">
        <option value="">Semua Poli</option>
        <?php foreach (($listPoli ?? []) as $poli) : ?>
          <option value="<?= esc($poli['id']) ?>" <?= ($_GET['poli'] ?? '') == $poli['id'] ? 'selected' : '' ?>>
            <?= esc($poli['nama_poli']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <button type="submit" class="btn-action bg-blue w-100 justify-content-center">
        <i class="bi bi-funnel"></i> Terapkan Filter
      </button>
    </div>
  </form>
</div>

<!-- ============ KOP LAPORAN (khusus tampil saat print) ============ -->
<div class="d-none d-print-block mb-4">
  <div class="d-flex align-items-center gap-3 border-bottom border-dark pb-3 mb-2">
    <i class="bi bi-hospital" style="font-size:32px;"></i>
    <div>
      <h4 class="mb-0 fw-bold">Laporan Pendaftaran Pasien</h4>
      <div style="font-size:13px;">
        Periode: <?= esc($tanggalMulai) ?> s/d <?= esc($tanggalAkhir) ?>
        &nbsp;|&nbsp; Dicetak: <?= date('d M Y H:i') ?>
      </div>
    </div>
  </div>
</div>

<!-- ============ RINGKASAN ============ -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-4">
    <div class="stat-card bg-blue">
      <div class="stat-label">Total Pendaftaran</div>
      <div class="stat-value"><?= number_format($totalPendaftaran) ?></div>
      <i class="bi bi-clipboard2-data-fill stat-icon"></i>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="stat-card bg-green">
      <div class="stat-label">Selesai Dilayani</div>
      <div class="stat-value"><?= number_format($totalSelesai) ?></div>
      <i class="bi bi-check-circle-fill stat-icon"></i>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="stat-card bg-slate">
      <div class="stat-label">Menunggu</div>
      <div class="stat-value"><?= number_format($totalMenunggu) ?></div>
      <i class="bi bi-hourglass-split stat-icon"></i>
    </div>
  </div>
</div>

<!-- ============ TABEL LAPORAN ============ -->
<div class="card-panel">
  <div class="panel-title">Detail Pendaftaran</div>
  <div class="panel-subtitle">Total <?= count($dataLaporan) ?> data ditemukan</div>

  <div class="table-responsive">
    <table class="table table-modern">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>No. Antrian</th>
          <th>No. RM</th>
          <th>Nama Pasien</th>
          <th>Poli</th>
          <th>Dokter</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($dataLaporan)) : ?>
        <tr>
          <td colspan="8" class="text-center text-muted-c py-4">Tidak ada data pada periode ini.</td>
        </tr>
        <?php else : ?>
          <?php $no = 1; foreach ($dataLaporan as $row) : ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d M Y', strtotime($row['tanggal_daftar'])) ?></td>
            <td><?= esc($row['no_antrian']) ?></td>
            <td><?= esc($row['no_rm']) ?></td>
            <td><?= esc($row['nama_pasien']) ?></td>
            <td><?= esc($row['poli']) ?></td>
            <td><?= esc($row['dokter']) ?></td>
            <td><span class="badge-status status-<?= esc($row['status_class']) ?>"><?= esc($row['status']) ?></span></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ============ TANDA TANGAN (khusus print) ============ -->
<div class="d-none d-print-flex justify-content-end mt-5">
  <div class="text-center" style="width:220px;">
    <div>Mengetahui,</div>
    <div style="height:70px;"></div>
    <div class="fw-bold" style="border-top:1px solid #000; padding-top:4px;">Administrator</div>
  </div>
</div>

<?= view('templates/footer') ?>