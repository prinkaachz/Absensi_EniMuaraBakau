<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape(isset($title) ? $title . ' - ' : '') ?>Eni Muara Bakau</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/override.css') . '?v=20260917e' ?>">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="<?= site_url('dashboard') ?>">
            <img class="brand-logo" src="<?= base_url('assets/images/eni-logo-sidebar.svg') ?>" alt="Eni Muara Bakau" width="60" height="66">
            <span><strong>Eni</strong><small>Muara Bakau</small></span>
        </a>
        <nav class="nav-menu">
            <?php if ($user['role'] === 'pegawai'): ?><a class="nav-link <?= uri_string() === 'aktivitas' ? 'active' : '' ?>" href="<?= site_url('aktivitas') ?>"><span>Aktivitas Saya</span></a><?php endif; ?>
            <?php if ($user['role'] === 'atasan'): ?><a class="nav-link <?= strpos(uri_string(), 'approval') === 0 ? 'active' : '' ?>" href="<?= site_url('approval') ?>">✓ <span>Review Pengajuan</span></a><?php endif; ?>
            <?php if ($user['role'] === 'monitoring'): ?><a class="nav-link <?= strpos(uri_string(), 'monitoring') === 0 ? 'active' : '' ?>" href="<?= site_url('monitoring') ?>">▤ <span>List Pegawai</span></a><?php endif; ?>
        </nav>
        <div class="sidebar-bottom"><span class="role-chip"><?= html_escape(ucfirst($user['role'])) ?></span><a href="<?= site_url('logout') ?>" data-logout>↪ Keluar</a></div>
    </aside>
    <main class="main-content">
        <header class="topbar"><button class="menu-toggle" data-toggle-sidebar>☰</button><div class="topbar-right"><a class="notification-button" href="<?= site_url('notifications') ?>" aria-label="Notifikasi: <?= (int) $notification_count ?> belum dibaca" title="Lihat notifikasi"><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg><?php if ($notification_count): ?><span class="notification-dot"><?= (int) $notification_count ?></span><?php endif; ?></a><span class="avatar"><?= strtoupper(substr($user['nama'], 0, 1)) ?></span><div><strong><?= html_escape($user['nama']) ?></strong><small><?= html_escape(ucfirst($user['role'])) ?></small></div></div></header>
        <section class="page-heading"><div><p class="eyebrow">ENI MUARA BAKAU</p><h1><?= html_escape($title) ?></h1></div><div class="breadcrumb"><a href="<?= site_url('dashboard') ?>">Dashboard</a><span>/</span><span><?= html_escape($title) ?></span></div></section>
        <section class="page-content">
<?php if ($this->session->flashdata('toast_success')): ?><div class="toast toast-success" data-toast><?= $this->session->flashdata('toast_success') ?></div><?php endif; ?>
<?php if ($this->session->flashdata('toast_error')): ?><div class="toast toast-error" data-toast><?= $this->session->flashdata('toast_error') ?></div><?php endif; ?>
