<?php
$token = bin2hex(random_bytes(32));
$this->session->set_userdata('logout_token', $token);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi keluar</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/override.css') ?>">
</head>
<body class="login-page">
    <main class="login-card">
        <h1>Keluar dari akun?</h1>
        <p>Anda perlu masuk kembali untuk mengakses aktivitas.</p>
        <?= form_open('logout') ?>
            <input type="hidden" name="logout_token" value="<?= html_escape($token) ?>">
            <a class="btn btn-light" href="<?= site_url('dashboard') ?>">Batal</a>
            <button class="btn btn-danger" type="submit">Ya, keluar</button>
        <?= form_close() ?>
    </main>
</body>
</html>
