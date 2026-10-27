<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html', true, 303);
    exit;
}

$kecamatan = trim((string) ($_POST['kecamatan'] ?? ''));
$longitudeInput = trim((string) ($_POST['longitude'] ?? ''));
$latitudeInput = trim((string) ($_POST['latitude'] ?? ''));
$luasInput = trim((string) ($_POST['luas'] ?? ''));
$jumlahInput = trim((string) ($_POST['jumlah_penduduk'] ?? ''));
$errors = [];

if ($kecamatan === '' || mb_strlen($kecamatan) > 100) {
    $errors[] = 'Nama kecamatan wajib diisi dan maksimal 100 karakter.';
}
foreach ([
    'Longitude' => [$longitudeInput, -180, 180],
    'Latitude' => [$latitudeInput, -90, 90],
    'Luas' => [$luasInput, 0, null],
] as $label => [$value, $minimum, $maximum]) {
    if ($value === '' || !is_numeric($value)) {
        $errors[] = $label . ' harus berupa angka.';
        continue;
    }
    $number = (float) $value;
    if ($number < $minimum || ($maximum !== null && $number > $maximum) || ($label === 'Luas' && $number <= 0)) {
        $errors[] = $label . ' berada di luar rentang yang diperbolehkan.';
    }
}
if ($jumlahInput === '' || filter_var($jumlahInput, FILTER_VALIDATE_INT) === false || (int) $jumlahInput < 0) {
    $errors[] = 'Jumlah penduduk harus berupa bilangan bulat minimal 0.';
}

if ($errors !== []) {
    http_response_code(422);
    ?>
    <!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Periksa input</title></head>
    <body><h1>Data belum dapat disimpan</h1><ul>
    <?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li><?php endforeach; ?>
    </ul><p><a href="index.html">Kembali ke formulir</a></p></body></html>
    <?php
    exit;
}

require dirname(__DIR__) . '/db.php';
$longitude = (float) $longitudeInput;
$latitude = (float) $latitudeInput;
$luas = (float) $luasInput;
$jumlahPenduduk = (int) $jumlahInput;
$stmt = $conn->prepare(
    'INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk) VALUES (?, ?, ?, ?, ?)'
);

if ($stmt === false) {
    http_response_code(500);
    exit('Pernyataan penyimpanan tidak dapat disiapkan.');
}

$stmt->bind_param('sdddi', $kecamatan, $longitude, $latitude, $luas, $jumlahPenduduk);
if (!$stmt->execute()) {
    http_response_code(500);
    exit('Data gagal disimpan. Periksa struktur tabel penduduk.');
}

$stmt->close();
$conn->close();
header('Location: ../index.php?saved=1', true, 303);
exit;
