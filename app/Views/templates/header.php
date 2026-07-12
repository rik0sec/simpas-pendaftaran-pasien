<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Dashboard' ?> - SIMPAS</title>

  <!-- Bootstrap 5.3 (mendukung dark mode via data-bs-theme) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

  <!-- Set tema dark/light SEBELUM body dirender, biar tidak "kedip" -->
  <script>
    (function () {
      var t = localStorage.getItem('simpas-theme') ||
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
      document.documentElement.setAttribute('data-bs-theme', t);
    })();
  </script>
</head>
<body>

<div class="app-wrapper">

  <?= view('templates/sidebar') ?>

  <div class="app-main">

    <!-- ============ TOPBAR ============ -->
    <nav class="topbar">
      <button class="btn-icon d-lg-none" id="sidebarToggle" type="button">
        <i class="bi bi-list"></i>
      </button>

      <div class="topbar-greeting d-none d-sm-block">
        <span class="greeting-label" id="greetingLabel">Selamat datang,</span>
        <h6 class="mb-0 fw-semibold" id="greetingTime">-</h6>
      </div>

      <div class="topbar-actions">
        <button class="btn-icon" id="darkModeToggle" type="button" title="Ganti tema terang/gelap">
          <i class="bi bi-moon-stars-fill" id="darkModeIcon"></i>
        </button>

        <div class="dropdown">
          <button class="btn-user dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <span class="user-avatar">
              <?= strtoupper(substr(session('nama') ?? 'A', 0, 1)) ?>
            </span>
            <span class="d-none d-md-inline"><?= esc(session('nama') ?? 'Administrator') ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('profil') ?>"><i class="bi bi-person"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ============ /TOPBAR ============ -->

    <main class="app-content">
