<?php
declare(strict_types=1);

/**
 * Shared MySQL connection for the Latihan 8 application.
 * Override these values with environment variables when your local setup differs.
 */
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = ''; // kosong jika MySQL XAMPP tidak memakai password
$dbName = 'latihan';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    http_response_code(500);
    exit('Koneksi basis data gagal. Periksa pengaturan MySQL di db.php.');
}

$conn->set_charset('utf8mb4');
