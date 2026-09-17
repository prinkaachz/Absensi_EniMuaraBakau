<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Eni Muara Bakau</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/override.css') ?>">
</head>
<body class="login-page">
    <div class="login-orb orb-one"></div>
    <div class="login-orb orb-two"></div>
    <main class="login-card">
        <div class="login-brand">
            <img class="login-logo" src="<?= base_url('assets/images/eni-logo.svg') ?>" alt="Eni Muara Bakau">
            <div><b>Eni Muara Bakau</b><small>Work Activity &amp; Permit</small></div>
        </div>
        <div class="login-copy">
            <p class="eyebrow">SELAMAT DATANG</p>
            <h1>Masuk ke ruang kerja Anda.</h1>
            <p>Catat aktivitas, kelola perizinan, dan pantau pengajuan dalam satu sistem.</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="form-error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Username<input name="username" autocomplete="username" placeholder="Masukkan username" required></label>
            <label>Kata sandi<input name="password" type="password" autocomplete="current-password" placeholder="Masukkan kata sandi" required></label>
            <button class="btn btn-primary btn-block" type="submit">Masuk <span>→</span></button>
        </form>
        <div class="demo-accounts">
            <b>Akun demo</b>
            <span>demo_pegawai · demo_atasan · demo_monitoring</span>
            <small>Password seluruh akun: <code>password123</code></small>
        </div>
    </main>
</body>
</html>
