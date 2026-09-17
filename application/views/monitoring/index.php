<div class="panel">
    <div class="panel-toolbar">
        <div>
            <h2>Daftar Pegawai</h2>
            <p>Akses read-only untuk meninjau aktivitas yang telah disetujui.</p>
        </div>
    </div>
    <form class="table-controls">
        <input type="search" name="q" value="<?= html_escape($this->input->get('q')) ?>" placeholder="Pencarian nama, jabatan, NIK...">
    </form>
    <div class="table-wrap">
        <table data-table>
            <thead><tr><th>No</th><th>Nama</th><th>Jabatan</th><th>NIK</th><th>Keterangan</th></tr></thead>
            <tbody>
            <?php foreach ($employees as $i => $employee): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><b><?= html_escape($employee['nama']) ?></b></td>
                    <td><?= html_escape($employee['jabatan']) ?></td>
                    <td><?= html_escape($employee['nik']) ?></td>
                    <td><a class="btn btn-primary btn-small" href="<?= base_url('monitoring/pegawai/' . $employee['id']) ?>">⌕ Detail</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-footer" data-pagination></div>
</div>
