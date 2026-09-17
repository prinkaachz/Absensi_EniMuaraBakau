<div class="panel">
    <div class="panel-toolbar">
        <div>
            <h2>Pembaruan Pengajuan</h2>
            <p>Notifikasi otomatis ditandai dibaca saat halaman ini dibuka.</p>
        </div>
        <a class="btn btn-light" href="<?= site_url('dashboard') ?>">← Kembali</a>
    </div>
    <?php if (!$items): ?>
        <p class="muted">Belum ada notifikasi. Keputusan atasan akan tampil di sini.</p>
    <?php endif; ?>
    <?php foreach ($items as $item): ?>
        <article class="notification-item <?= $item['is_read'] ? '' : 'unread' ?>">
            <h3><?= html_escape($item['title']) ?></h3>
            <p><?= html_escape($item['message']) ?></p>
            <small><?= html_escape($item['created_at']) ?></small>
        </article>
    <?php endforeach; ?>
</div>
