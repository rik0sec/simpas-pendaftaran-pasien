<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistem Pendaftaran Pasien</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --brand-1:#2563eb;
    --brand-2:#0ea5e9;
    --ink:#0f172a;
    --muted:#64748b;
  }

  * { font-family: 'Poppins', sans-serif; }

  body {
    min-height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--brand-1) 0%, var(--brand-2) 100%);
    position: relative;
    overflow: hidden;
  }

  /* decorative blobs */
  body::before, body::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    filter: blur(10px);
    opacity: .25;
  }
  body::before {
    width: 420px; height: 420px;
    background: #ffffff;
    top: -140px; left: -120px;
  }
  body::after {
    width: 320px; height: 320px;
    background: #ffffff;
    bottom: -120px; right: -100px;
  }

  .login-wrapper {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 420px;
    padding: 0 16px;
  }

  .login-card {
    background: rgba(255, 255, 255, 0.97);
    border-radius: 20px;
    box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25);
    padding: 40px 36px 32px;
    animation: fadeUp .5s ease-out;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .brand-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.35);
  }
  .brand-icon i { color: #fff; font-size: 28px; }

  .login-title {
    text-align: center;
    font-weight: 700;
    font-size: 1.35rem;
    color: var(--ink);
    margin-bottom: 2px;
  }
  .login-subtitle {
    text-align: center;
    color: var(--muted);
    font-size: .875rem;
    margin-bottom: 28px;
  }

  .form-label {
    font-weight: 500;
    font-size: .85rem;
    color: var(--ink);
  }

  .input-group-modern {
    position: relative;
  }
  .input-group-modern i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: .9rem;
  }
  .input-group-modern input {
    padding-left: 40px;
    height: 46px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    font-size: .9rem;
    transition: all .2s ease;
  }
  .input-group-modern input:focus {
    border-color: var(--brand-1);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  }

  .btn-login {
    height: 46px;
    border-radius: 10px;
    font-weight: 600;
    font-size: .95rem;
    background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
    border: none;
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.35);
  }
  .btn-login:active { transform: translateY(0); }

  .alert-modern {
    border-radius: 10px;
    font-size: .85rem;
    border: none;
  }

  .footer-note {
    text-align: center;
    font-size: .78rem;
    color: rgba(255,255,255,0.85);
    margin-top: 18px;
  }
</style>
</head>
<body>

<div class="login-wrapper">

  <div class="login-card">
    <div class="brand-icon">
      <i class="fa-solid fa-hospital"></i>
    </div>
    <h4 class="login-title">Sistem Pendaftaran Pasien</h4>
    <p class="login-subtitle">Masuk untuk melanjutkan ke dashboard Anda</p>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-modern"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
      <div class="alert alert-success alert-modern"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger alert-modern">
        <ul class="mb-0 ps-3">
          <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-group-modern">
          <i class="fa-regular fa-envelope"></i>
          <input type="email" name="email" class="form-control"
                 placeholder="nama@email.com"
                 value="<?= old('email') ?>" required autofocus>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="input-group-modern">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" class="form-control"
                 placeholder="••••••••" required>
        </div>
      </div>

      <button type="submit" class="btn btn-login btn-primary w-100 text-white">
        <i class="fa-solid fa-right-to-bracket me-2"></i>Login
      </button>
    </form>
  </div>

  <p class="footer-note">&copy; <?= date('Y') ?> Sistem Pendaftaran Pasien. All rights reserved.</p>

</div>

</body>
</html>