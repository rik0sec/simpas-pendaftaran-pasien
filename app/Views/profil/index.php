<?= view('templates/header') ?>
<?= view('templates/sidebar') ?>

<div class="page-heading">
  <div>
    <h2>Profil Saya</h2>
    <p class="text-muted mb-0">Kelola informasi akun dan keamanan login kamu</p>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success border-0 rounded-3 mb-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger border-0 rounded-3 mb-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row g-3">

  <!-- ============ KARTU RINGKASAN PROFIL ============ -->
  <div class="col-12 col-lg-4">
    <div class="card-panel text-center h-100">
      <div class="profile-avatar-wrap mx-auto mb-3">
        <?php if (!empty($user['foto'])): ?>
          <img src="<?= base_url('uploads/foto_profil/' . $user['foto']) ?>" class="profile-avatar-img" alt="Foto Profil">
        <?php else: ?>
          <div class="profile-avatar-fallback">
            <?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?>
          </div>
        <?php endif; ?>

        <label for="fotoInput" class="profile-avatar-edit" title="Ganti foto">
          <i class="bi bi-camera-fill"></i>
        </label>
      </div>

      <h5 class="mb-1"><?= esc($user['nama'] ?? '-') ?></h5>
      <span class="role-badge role-<?= strtolower($user['role'] ?? 'admin') ?>">
        <i class="bi bi-shield-check"></i> <?= esc(ucfirst($user['role'] ?? 'Admin')) ?>
      </span>

      <hr class="border-c my-4">

      <ul class="list-unstyled text-start mb-0" style="font-size:13.5px;">
        <li class="d-flex justify-content-between py-2 border-bottom border-c">
          <span class="text-muted-c"><i class="bi bi-envelope me-2"></i>Email</span>
          <span class="fw-semibold"><?= esc($user['email'] ?? '-') ?></span>
        </li>
        <li class="d-flex justify-content-between py-2 border-bottom border-c">
          <span class="text-muted-c"><i class="bi bi-telephone me-2"></i>No. HP</span>
          <span class="fw-semibold"><?= esc($user['no_hp'] ?? '-') ?></span>
        </li>
        <li class="d-flex justify-content-between py-2">
          <span class="text-muted-c"><i class="bi bi-clock-history me-2"></i>Login Terakhir</span>
          <span class="fw-semibold"><?= esc($user['last_login'] ?? 'Sesi ini') ?></span>
        </li>
      </ul>
    </div>
  </div>

  <!-- ============ FORM EDIT PROFIL & PASSWORD ============ -->
  <div class="col-12 col-lg-8">

    <!-- Tabs -->
    <ul class="nav profile-tabs mb-3" id="profileTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabInfo" type="button">
          <i class="bi bi-person-lines-fill me-1"></i> Informasi Akun
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabPassword" type="button">
          <i class="bi bi-lock-fill me-1"></i> Keamanan
        </button>
      </li>
    </ul>

    <div class="tab-content">

      <!-- ---- TAB: Informasi Akun ---- -->
      <div class="tab-pane fade show active" id="tabInfo">
        <div class="card-panel">
          <div class="panel-title">Edit Informasi Akun</div>
          <div class="panel-subtitle">Perbarui data diri kamu di sini</div>

          <form action="<?= base_url('profil/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="file" id="fotoInput" name="foto" accept="image/*" class="d-none">

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= old('nama', $user['nama'] ?? '') ?>" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= old('email', $user['email'] ?? '') ?>" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control"
                       value="<?= old('no_hp', $user['no_hp'] ?? '') ?>">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" value="<?= esc(ucfirst($user['role'] ?? '-')) ?>" disabled>
                <div class="form-text">Role hanya bisa diubah oleh Administrator lain.</div>
              </div>
            </div>

            <button type="submit" class="btn-action bg-blue mt-4">
              <i class="bi bi-check2-circle"></i> Simpan Perubahan
            </button>
          </form>
        </div>
      </div>

      <!-- ---- TAB: Keamanan / Ganti Password ---- -->
      <div class="tab-pane fade" id="tabPassword">
        <div class="card-panel">
          <div class="panel-title">Ganti Password</div>
          <div class="panel-subtitle">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik</div>

          <form action="<?= base_url('profil/update-password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label class="form-label">Password Lama</label>
              <input type="password" name="password_lama" class="form-control" required>
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" minlength="8" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_konfirmasi" class="form-control" minlength="8" required>
              </div>
            </div>

            <button type="submit" class="btn-action bg-blue mt-4">
              <i class="bi bi-shield-lock"></i> Perbarui Password
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  .profile-avatar-wrap{
    position:relative;
    width:96px;
    height:96px;
  }
  .profile-avatar-img{
    width:96px; height:96px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid var(--bg-card);
    box-shadow:0 4px 14px rgba(15,23,42,.12);
  }
  .profile-avatar-fallback{
    width:96px; height:96px;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg, var(--color-primary), var(--color-cyan));
    color:#fff;
    font-size:34px;
    font-weight:700;
    box-shadow:0 4px 14px rgba(15,23,42,.12);
  }
  .profile-avatar-edit{
    position:absolute;
    bottom:0; right:0;
    width:30px; height:30px;
    border-radius:50%;
    background:var(--bg-card);
    border:1px solid var(--border-color);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
    font-size:13px;
    color:var(--text-main);
    transition:background-color .15s ease;
  }
  .profile-avatar-edit:hover{ background:var(--bg-body); }

  .role-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
  }
  .role-badge.role-admin{ background:var(--color-primary-soft); color:var(--color-primary-dark); }
  .role-badge.role-petugas{ background:var(--color-green-soft); color:var(--color-green); }

  .profile-tabs{
    border-bottom:1px solid var(--border-color);
    gap:4px;
  }
  .profile-tabs .nav-link{
    border:none;
    background:transparent;
    color:var(--text-muted);
    font-weight:600;
    font-size:13.5px;
    padding:10px 16px;
    border-radius:10px 10px 0 0;
  }
  .profile-tabs .nav-link.active{
    color:var(--color-primary);
    background:var(--bg-card);
    border-bottom:2px solid var(--color-primary);
  }
</style>

<script>
  document.getElementById('fotoInput')?.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      this.closest('form').submit();
    }
  });
</script>

<?= view('templates/footer') ?>