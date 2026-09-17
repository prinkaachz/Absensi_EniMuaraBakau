<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: dejavusans, sans-serif; color: #000; font-size: 10.5pt; }
        .header { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .header td { border: 0; vertical-align: top; }
        .id-survey { width: 128px; height: auto; }
        .surveyor { width: 87px; height: auto; }
        .right { text-align: right; }
        .title { text-align: center; font-size: 16pt; font-weight: normal; margin: 0 0 2px; }
        .scope { text-align: center; font-size: 10pt; line-height: 1.3; margin: 0 30px 16px; }
        .identity { width: 100%; border-collapse: collapse; margin: 0 0 18px 4px; }
        .identity td { border: 0; padding: 2px 0; font-size: 10pt; }
        .identity .label { width: 142px; }
        .identity .colon { width: 18px; }
        .timesheet { width: 100%; border-collapse: collapse; }
        .timesheet th, .timesheet td { border: 0.6px solid #000; padding: 5px 6px; vertical-align: top; }
        .timesheet th { text-align: center; font-size: 11pt; font-weight: normal; }
        .timesheet .date { width: 24%; text-align: center; }
        .timesheet .status { width: 24%; text-align: center; }
        .timesheet .activity { width: 52%; line-height: 1.35; }
        .signatures { width: 100%; border-collapse: collapse; margin-top: 82px; }
        .signatures td { width: 50%; border: 0; text-align: center; vertical-align: top; }
        .qr-space { width: 68px; height: 68px; margin: 15px auto 0; border: 0.6px solid #bbb; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td><img class="id-survey" src="<?= FCPATH ?>assets/images/pdf-template/I1.png" alt="ID Survey"></td>
            <td class="right"><img class="surveyor" src="<?= FCPATH ?>assets/images/pdf-template/I2.png" alt="Surveyor Indonesia"></td>
        </tr>
    </table>

    <h1 class="title">TIMESHEET</h1>
    <p class="scope">Provision of QHSSE Management System and Contractor HSE Management System Services<br>Eni Muara Bakau B.V.</p>

    <table class="identity">
        <tr><td class="label">Employee Name</td><td class="colon">:</td><td><?= html_escape($employee['nama']) ?></td></tr>
        <tr><td class="label">Position</td><td class="colon">:</td><td><?= html_escape($employee['jabatan']) ?></td></tr>
        <tr><td class="label">Period</td><td class="colon">:</td><td><?= date('d/m/Y', strtotime($filters['start'])) ?> until <?= date('d/m/Y', strtotime($filters['end'])) ?></td></tr>
    </table>

    <table class="timesheet">
        <thead><tr><th class="date">DATE</th><th class="status">STATUS</th><th class="activity">ACTIVITY</th></tr></thead>
        <tbody>
        <?php if (empty($activities)): ?>
            <tr><td colspan="3">No approved activities within this period.</td></tr>
        <?php endif; ?>
        <?php foreach ($activities as $item): ?>
            <tr>
                <td class="date"><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
                <td class="status"><?= html_escape($item['jenis']) ?></td>
                <td class="activity">- <?= nl2br(html_escape($item['kegiatan'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>Employee,<div class="qr-space"></div></td>
            <td>Mengetahui,<div class="qr-space"></div></td>
        </tr>
    </table>
</body>
</html>
