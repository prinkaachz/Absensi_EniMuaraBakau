CREATE DATABASE IF NOT EXISTS `Absensi_EniMuaraBakau` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `Absensi_EniMuaraBakau`;

CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(120) NOT NULL,
  `username` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('pegawai','atasan','monitoring') NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB;

CREATE TABLE `pegawai` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `nama` VARCHAR(120) NOT NULL,
  `jabatan` VARCHAR(120) NOT NULL,
  `nik` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`), UNIQUE KEY `pegawai_user_unique` (`user_id`), UNIQUE KEY `nik_unique` (`nik`),
  CONSTRAINT `pegawai_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `aktivitas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` DATE NOT NULL,
  `jenis` ENUM('On Duty','Off Duty','Perjalanan Dinas','Cuti') NOT NULL,
  `sub_status` VARCHAR(120) NOT NULL,
  `kegiatan` TEXT NOT NULL,
  `dokumen` VARCHAR(255) DEFAULT NULL,
  `status_approval` ENUM('Not Approved','Approved','Rejected') NOT NULL DEFAULT 'Not Approved',
  `catatan_reject` TEXT DEFAULT NULL,
  `id_pegawai` INT UNSIGNED NOT NULL,
  `id_approver` INT UNSIGNED DEFAULT NULL,
  `approved_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `aktivitas_pegawai_idx` (`id_pegawai`), KEY `aktivitas_status_idx` (`status_approval`),
  CONSTRAINT `aktivitas_pegawai_fk` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`),
  CONSTRAINT `aktivitas_approver_fk` FOREIGN KEY (`id_approver`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `notifications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(180) NOT NULL,
  `message` TEXT NOT NULL,
  `type` VARCHAR(30) NOT NULL DEFAULT 'info',
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `notification_user_idx` (`user_id`),
  CONSTRAINT `notification_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Password seluruh akun demo: password123
INSERT INTO `users` (`id`,`nama`,`username`,`password`,`role`) VALUES
(1,'Dimas Pratama','demo_pegawai','$2y$12$YIPV33eivavhbiqr/fZseeNPjAWh2QDdSH.zFS7fz/12KOc.Dw3wy','pegawai'),
(2,'Rina Kurniawan','demo_atasan','$2y$12$YIPV33eivavhbiqr/fZseeNPjAWh2QDdSH.zFS7fz/12KOc.Dw3wy','atasan'),
(3,'Tim Monitoring','demo_monitoring','$2y$12$YIPV33eivavhbiqr/fZseeNPjAWh2QDdSH.zFS7fz/12KOc.Dw3wy','monitoring'),
(4,'Siti Rahma','pegawai_siti','$2y$12$YIPV33eivavhbiqr/fZseeNPjAWh2QDdSH.zFS7fz/12KOc.Dw3wy','pegawai');
INSERT INTO `pegawai` (`id`,`user_id`,`nama`,`jabatan`,`nik`) VALUES
(1,1,'Dimas Pratama','HSE Officer','ENI-2026-001'),(2,4,'Siti Rahma','Field Administrator','ENI-2026-002');
INSERT INTO `aktivitas` (`tanggal`,`jenis`,`sub_status`,`kegiatan`,`status_approval`,`id_pegawai`,`id_approver`,`approved_at`) VALUES
('2026-09-15','On Duty','Operasional Lapangan','Inspeksi keselamatan area kerja dan koordinasi toolbox meeting pagi.','Approved',1,2,NOW()),
('2026-09-16','Perjalanan Dinas','Site Visit','Kunjungan lokasi untuk verifikasi kebutuhan operasional proyek.','Not Approved',1,NULL,NULL),
('2026-09-12','Cuti','Cuti Tahunan','Pengajuan cuti tahunan untuk keperluan keluarga.','Rejected',1,2,NOW()),
('2026-09-14','On Duty','Administrasi','Penyusunan laporan administrasi kegiatan mingguan.','Approved',2,2,NOW());
UPDATE `aktivitas` SET `catatan_reject`='Periode cuti perlu disesuaikan dengan jadwal personel pengganti.' WHERE `status_approval`='Rejected';
