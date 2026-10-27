<?php
declare(strict_types=1);

require __DIR__ . '/db.php';

$result = $conn->query(
    'SELECT id, kecamatan, longitude, latitude, luas, jumlah_penduduk FROM penduduk ORDER BY id'
);

if ($result === false) {
    http_response_code(500);
    exit('Data tidak dapat dibaca. Pastikan tabel penduduk sudah dibuat.');
}

function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Penduduk Kecamatan</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; color: #172033; background: #f3f6fb; }
        body { max-width: 1100px; margin: 0 auto; padding: 32px 20px; }
        h1 { margin-bottom: 8px; }
        .intro { color: #526078; margin-top: 0; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin: 24px 0 12px; }
        .button { display: inline-block; padding: 10px 16px; border-radius: 8px; color: white; background: #2459d3; text-decoration: none; font-weight: 650; }
        .table-wrap { overflow-x: auto; background: white; border: 1px solid #dce3ee; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e8edf4; text-align: left; }
        th { background: #edf2fa; color: #34415a; }
        td.number, th.number { text-align: right; }
        tbody tr:last-child td { border-bottom: 0; }
        .empty { padding: 24px; color: #526078; }
        .notice { margin: 16px 0; padding: 12px 14px; border-radius: 8px; color: #155d35; background: #e5f6eb; }
        footer { margin-top: 20px; color: #68758b; font-size: .9rem; }
    </style>
</head>
<body>
    <h1>Data Penduduk Kecamatan</h1>
    <p class="intro">Data luas wilayah, jumlah penduduk, dan koordinat setiap kecamatan.</p>
    <?php if (($_GET['saved'] ?? '') === '1'): ?>
        <div class="notice" role="status">Data kecamatan berhasil disimpan.</div>
    <?php endif; ?>
    <div class="toolbar">
        <strong><?= $result->num_rows ?> data</strong>
        <a class="button" href="input/index.html">＋ Tambah data</a>
    </div>
    <?php if ($result->num_rows > 0): ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kecamatan</th>
                        <th class="number">Longitude</th>
                        <th class="number">Latitude</th>
                        <th class="number">Luas (km²)</th>
                        <th class="number">Jumlah penduduk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= e($row['kecamatan']) ?></td>
                            <td class="number"><?= e($row['longitude']) ?></td>
                            <td class="number"><?= e($row['latitude']) ?></td>
                            <td class="number"><?= e($row['luas']) ?></td>
                            <td class="number"><?= number_format((int) $row['jumlah_penduduk'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="table-wrap empty">Belum ada data penduduk. Gunakan tombol “Tambah data” untuk memasukkan data pertama.</div>
    <?php endif; ?>
    <footer></footer>
</body>
</html>
<?php
$result->free();
$conn->close();
