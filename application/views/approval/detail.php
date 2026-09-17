<div class="review-navigation">
    <a class="btn btn-light" href="<?= site_url('approval') ?>">← Kembali ke Review Pengajuan</a>
</div>
<div class="detail-layout review-layout <?= $activity['status_approval'] === 'Not Approved' ? 'awaiting-decision' : 'decision-complete' ?>">
    <article class="panel">
        <div class="panel-toolbar">
            <div><p class="eyebrow">PENGAJUAN #<?= $activity['id'] ?></p><h2><?= html_escape($activity['nama']) ?></h2><p><?= html_escape($activity['jabatan']) ?> · <?= date('d F Y', strtotime($activity['tanggal'])) ?></p></div>
            <span class="badge <?= strtolower(str_replace(' ', '-', $activity['status_approval'])) ?>"><?= $activity['status_approval'] ?></span>
        </div>
        <dl class="detail-list">
            <div><dt>Jenis</dt><dd><?= html_escape($activity['jenis']) ?></dd></div>
            <div><dt>Sub kategori</dt><dd><?= html_escape($activity['sub_status']) ?></dd></div>
            <div class="full"><dt>Kegiatan</dt><dd><?= nl2br(html_escape($activity['kegiatan'])) ?></dd></div>
            <div><dt>Dokumen</dt><dd><?php if ($activity['dokumen']): ?><a class="file-link" target="_blank" href="<?= base_url('assets/uploads/' . $activity['dokumen']) ?>">Preview / Download ↗</a><?php else: ?>Tidak ada lampiran<?php endif; ?></dd></div>
            <?php if ($activity['catatan_reject']): ?><div><dt>Catatan reject</dt><dd><?= html_escape($activity['catatan_reject']) ?></dd></div><?php endif; ?>
        </dl>
    </article>
    <?php if ($activity['status_approval'] === 'Not Approved'): ?>
        <aside class="decision-card">
            <h3>Ambil keputusan</h3><p>Pastikan data dan dokumen telah diperiksa sebelum menyimpan keputusan.</p>
            <form method="post" action="<?= site_url('approval/putuskan/' . $activity['id']) ?>">
                <label>Catatan reject <small>(wajib hanya saat reject)</small><textarea name="catatan_reject" placeholder="Jelaskan alasan jika pengajuan ditolak..."></textarea></label>
                <div class="decision-actions">
                    <button class="btn btn-danger" type="submit" name="decision" value="Rejected">✕ Reject</button>
                    <button class="btn btn-success" type="submit" name="decision" value="Approved">✓ Approve</button>
                </div>
            </form>
        </aside>
    <?php endif; ?>
</div>
