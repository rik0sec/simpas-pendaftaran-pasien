<?php
// Helper kecil untuk menandai menu aktif berdasarkan segment URL pertama
// (tidak pakai function supaya aman kalau file ini ke-include lebih dari sekali)
$segment = service('uri')->getSegment(1) ?? '';
?>
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <span class="brand-icon"><i class="bi bi-hospital"></i></span>
    <span class="brand-text">SIMPAS</span>
  </div>

  <nav class="sidebar-nav">
    <span class="nav-section-label">Menu</span>
    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $segment === 'dashboard' ? 'active' : '' ?>">
      <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
    </a>

    <span class="nav-section-label">Data Master</span>
    <a href="<?= base_url('pasien') ?>" class="nav-link <?= $segment === 'pasien' ? 'active' : '' ?>">
      <i class="bi bi-person-vcard-fill"></i><span>Data Pasien</span>
    </a>
    <a href="<?= base_url('dokter') ?>" class="nav-link <?= $segment === 'dokter' ? 'active' : '' ?>">
      <i class="bi bi-person-badge-fill"></i><span>Data Dokter</span>
    </a>
    <a href="<?= base_url('poli') ?>" class="nav-link <?= $segment === 'poli' ? 'active' : '' ?>">
      <i class="bi bi-building-fill"></i><span>Data Poli</span>
    </a>

    <span class="nav-section-label">Transaksi</span>
    <a href="<?= base_url('pendaftaran') ?>" class="nav-link <?= $segment === 'pendaftaran' ? 'active' : '' ?>">
      <i class="bi bi-clipboard2-pulse-fill"></i><span>Pendaftaran</span>
    </a>
    <a href="<?= base_url('laporan') ?>" class="nav-link <?= $segment === 'laporan' ? 'active' : '' ?>">
      <i class="bi bi-bar-chart-line-fill"></i><span>Laporan</span>
    </a>
  </nav>
</aside>