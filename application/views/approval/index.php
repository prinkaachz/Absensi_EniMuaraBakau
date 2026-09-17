<?php
$status_options = array('' => 'Semua status', 'Not Approved' => 'Not Approved', 'Approved' => 'Approved', 'Rejected' => 'Rejected');
$selected_status = (string) $this->input->get('status');
if (!isset($status_options[$selected_status])) $selected_status = '';
?>
<div class="panel">
    <div class="panel-toolbar">
        <div>
            <h2>Antrean Persetujuan</h2>
            <p>Pengajuan pending diprioritaskan paling atas.</p>
        </div>
    </div>
    <form class="approval-filters" method="get" action="<?= site_url('approval') ?>">
        <label class="approval-field">
            <span>Pencarian</span>
            <span class="search-control">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/></svg>
                <input type="search" name="q" value="<?= html_escape($this->input->get('q')) ?>" placeholder="Nama pegawai atau jenis aktivitas">
            </span>
        </label>
        <label class="approval-field">
            <span>Tanggal pengajuan</span>
            <input type="date" name="tanggal" value="<?= html_escape($this->input->get('tanggal')) ?>">
        </label>
        <div class="approval-field">
            <span id="approvalStatusLabel">Status pengajuan</span>
            <details class="status-picker" data-status-picker>
                <summary aria-labelledby="approvalStatusLabel selectedStatus">
                    <span id="selectedStatus" data-status-label><?= html_escape($status_options[$selected_status]) ?></span>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </summary>
                <div class="status-options" role="group" aria-labelledby="approvalStatusLabel">
                    <?php foreach ($status_options as $value => $label): ?>
                        <label class="status-option">
                            <input type="radio" name="status" value="<?= html_escape($value) ?>" <?= $selected_status === $value ? 'checked' : '' ?>>
                            <span class="status-dot <?= $value === 'Approved' ? 'green' : ($value === 'Rejected' ? 'red' : ($value === '' ? 'gray' : 'gold')) ?>"></span>
                            <span><?= html_escape($label) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>
        </div>
        <div class="approval-filter-actions">
            <button class="btn btn-primary" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                Filter
            </button>
            <a class="btn btn-light" href="<?= site_url('approval') ?>" aria-label="Reset semua filter">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10a9 9 0 1 1 2 8M3 4v6h6"/></svg>
                Reset
            </a>
        </div>
    </form>
    <div class="table-wrap">
        <table data-table>
            <thead>
                <tr><th>Pengaju</th><th>Tanggal</th><th>Jenis</th><th>Kegiatan</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $item): ?>
                    <tr>
                        <td>
                            <b><?= html_escape($item['nama']) ?></b>
                            <small class="table-subtext"><?= html_escape($item['jabatan']) ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td><?= html_escape($item['jenis']) ?></td>
                        <td class="description-cell"><?= html_escape($item['kegiatan']) ?></td>
                        <td><span class="badge <?= strtolower(str_replace(' ', '-', $item['status_approval'])) ?>"><?= html_escape($item['status_approval']) ?></span></td>
                        <td><a class="btn btn-info btn-small" href="<?= site_url('approval/detail/' . $item['id']) ?>">Review</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$activities): ?>
                    <tr><td colspan="6" class="muted">Tidak ada pengajuan yang sesuai dengan filter.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
