<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>


<div class="page-heading">
  <div>
    <h2>Dashboard</h2>
    <p class="text-muted mb-0">Ringkasan aktivitas pendaftaran pasien hari ini</p>
  </div>
</div>

<!-- ============ STAT CARDS ============ -->
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="stat-card bg-blue">
      <div class="stat-label">Total Pasien</div>
      <div class="stat-value"><?= $total_pasien ?? 0 ?></div>
      <i class="bi bi-person-vcard-fill stat-icon"></i>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat-card bg-cyan">
      <div class="stat-label">Total Dokter</div>
      <div class="stat-value"><?= $total_dokter ?? 0 ?></div>
      <i class="bi bi-person-badge-fill stat-icon"></i>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat-card bg-slate">
      <div class="stat-label">Total Poli</div>
      <div class="stat-value"><?= $total_poli ?? 0 ?></div>
      <i class="bi bi-building-fill stat-icon"></i>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat-card bg-green">
      <div class="stat-label">Pendaftaran Hari Ini</div>
      <div class="stat-value"><?= $pendaftaran_hari_ini ?? 0 ?></div>
      <i class="bi bi-clipboard2-pulse-fill stat-icon"></i>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <!-- ============ CHART ============ -->
  <div class="col-12 col-xl-8">
    <div class="card-panel h-100">
      <div class="panel-title">Tren Pendaftaran</div>
      <div class="panel-subtitle mb-0">Jumlah pendaftaran pasien 14 hari terakhir</div>
      <div class="chart-wrap">
        <canvas id="chartPendaftaran"></canvas>
      </div>
    </div>
  </div>

  <!-- ============ QUICK ACTIONS ============ -->
  <div class="col-12 col-xl-4">
    <div class="card-panel h-100">
      <div class="panel-title">Aksi Cepat</div>
      <div class="panel-subtitle">Pintasan untuk tugas yang sering dilakukan</div>
      <div class="d-flex flex-column gap-2">
        <a href="<?= base_url('pasien/create') ?>" class="btn-action bg-blue">
          <i class="bi bi-person-add"></i> Tambah Pasien Baru
        </a>
        <a href="<?= base_url('pendaftaran/create') ?>" class="btn-action bg-green">
          <i class="bi bi-clipboard2-plus"></i> Daftarkan Pasien
        </a>
      </div>

      <hr class="border-c my-3">

      <div class="panel-title" style="font-size:14px;">Info Sistem</div>
      <ul class="list-unstyled mb-0" style="font-size:13px;">
        <li class="d-flex justify-content-between py-1 border-bottom border-c">
          <span class="text-muted-c">Tanggal</span>
          <span><?= date('d M Y') ?></span>
        </li>
      </ul>
    </div>
  </div>
</div>

<?php
// ---------------------------------------------------------------
// Data chart: kalau controller kamu BELUM kirim $chart_labels &
// $chart_data, di sini otomatis pakai data kosong (0) 14 hari
// terakhir supaya grafik tetap tampil (tidak error).
// Begitu controller sudah kirim datanya, otomatis kepakai beneran.
// ---------------------------------------------------------------
if (!isset($chart_labels) || !isset($chart_data)) {
    $chart_labels = [];
    $chart_data   = [];
    for ($i = 13; $i >= 0; $i--) {
        $chart_labels[] = date('d M', strtotime("-$i day"));
        $chart_data[]   = 0;
    }
}

$json_labels = json_encode($chart_labels);
$json_data   = json_encode($chart_data);

$pageScript = <<<HTML
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('chartPendaftaran');
  const labels = {$json_labels};
  const data = {$json_data};

  function buildChart() {
    const theme = window.SIMPAS.chartTheme();
    return new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Pendaftaran',
          data: data,
          fill: true,
          tension: 0.35,
          borderColor: '#2563eb',
          backgroundColor: 'rgba(37,99,235,0.12)',
          pointBackgroundColor: '#2563eb',
          pointRadius: 3,
          borderWidth: 2.5,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false }, ticks: { color: theme.text } },
          y: { beginAtZero: true, ticks: { color: theme.text, precision: 0 }, grid: { color: theme.grid } }
        }
      }
    });
  }

  let chart = buildChart();
  document.addEventListener('simpas:theme-changed', function () {
    chart.destroy();
    chart = buildChart();
  });
});
</script>
HTML;
?>

<?= view('templates/footer', ['pageScript' => $pageScript]) ?>