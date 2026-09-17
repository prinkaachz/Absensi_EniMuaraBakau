<section class="panel filter-panel">
    <div class="panel-toolbar">
        <div>
            <p class="eyebrow">AKTIVITAS PEGAWAI</p>
            <h2><?= html_escape($employee['nama']) ?></h2>
            <p><?= html_escape($employee['jabatan']) ?> · NIK <?= html_escape($employee['nik']) ?></p>
        </div>
        <a class="btn btn-light" href="<?= site_url('monitoring') ?>">← List Pegawai</a>
    </div>

    <form class="approval-filters monitoring-filters" method="get" action="<?= site_url('monitoring/pegawai/' . (int) $employee['id']) ?>">
        <label class="approval-field">
            <span>Tanggal mulai</span>
            <input type="date" name="mulai" aria-label="Tanggal mulai" value="<?= html_escape($filters['start']) ?>">
        </label>
        <label class="approval-field">
            <span>Tanggal akhir</span>
            <input type="date" name="akhir" aria-label="Tanggal akhir" value="<?= html_escape($filters['end']) ?>">
        </label>
        <div class="approval-filter-actions">
            <button class="btn btn-primary" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                Cari
            </button>
            <a class="btn btn-light" href="<?= site_url('monitoring/pegawai/' . (int) $employee['id']) ?>" title="Hapus filter tanggal dan tampilkan semua aktivitas">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10a9 9 0 1 1 2 8M3 4v6h6"/></svg>
                Reset
            </a>
        </div>
        <a class="btn btn-success report-download" href="<?= site_url('monitoring/laporan/' . (int) $employee['id']) . '?' . html_escape(http_build_query(array('mulai' => $filters['start'], 'akhir' => $filters['end']))) ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9V3h12v6M6 17H3V9h18v8h-3M6 14h12v7H6zM17 12h1"/></svg>
            Cetak Laporan
        </a>
    </form>
</section>

<section class="panel">
    <div class="table-wrap">
        <table data-table data-sortable>
            <thead>
                <tr>
                    <th>No</th>
                    <th data-sortable>Tanggal ↕</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td data-sort="<?= html_escape($item['tanggal']) ?>"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td><?= html_escape($item['jenis']) ?></td>
                        <td class="description-cell"><?= nl2br(html_escape($item['kegiatan'])) ?></td>
                        <td>
                            <span class="badge <?= strtolower(str_replace(' ', '-', $item['status_approval'])) ?>">
                                <?= html_escape($item['status_approval']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-footer" data-pagination></div>
</section>
