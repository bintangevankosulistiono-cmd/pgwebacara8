CREATE DATABASE IF NOT EXISTS latihan
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE latihan;

CREATE TABLE IF NOT EXISTS penduduk (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  kecamatan VARCHAR(100) NOT NULL,
  longitude DECIMAL(10, 6) NOT NULL,
  latitude DECIMAL(10, 6) NOT NULL,
  luas DECIMAL(10, 2) NOT NULL,
  jumlah_penduduk INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  CHECK (longitude BETWEEN -180 AND 180),
  CHECK (latitude BETWEEN -90 AND 90),
  CHECK (luas > 0)
);

INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk)
SELECT 'Moyudan', 110.2478, -7.7774, 27.62, 31497
WHERE NOT EXISTS (SELECT 1 FROM penduduk WHERE kecamatan = 'Moyudan');
INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk)
SELECT 'Minggir', 110.2484, -7.7318, 27.27, 29886
WHERE NOT EXISTS (SELECT 1 FROM penduduk WHERE kecamatan = 'Minggir');
INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk)
SELECT 'Seyegan', 110.3003, -7.7265, 26.63, 47129
WHERE NOT EXISTS (SELECT 1 FROM penduduk WHERE kecamatan = 'Seyegan');
INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk)
SELECT 'Godean', 110.2957, -7.7681, 26.84, 72028
WHERE NOT EXISTS (SELECT 1 FROM penduduk WHERE kecamatan = 'Godean');
INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk)
SELECT 'Gamping', 110.3202, -7.7903, 29.25, 108675
WHERE NOT EXISTS (SELECT 1 FROM penduduk WHERE kecamatan = 'Gamping');
