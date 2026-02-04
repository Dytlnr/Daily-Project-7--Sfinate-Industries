/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : konveksi

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 03/11/2025 20:58:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint(20) unsigned DEFAULT NULL,
  `kode_masuk` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_modal` decimal(15,2) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barang_masuk_kode_masuk_unique` (`kode_masuk`),
  KEY `barang_masuk_barang_id_foreign` (`barang_id`),
  CONSTRAINT `barang_masuk_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of barang_masuk
-- ----------------------------
BEGIN;
INSERT INTO `barang_masuk` (`id`, `barang_id`, `kode_masuk`, `nama_barang`, `jumlah`, `harga_modal`, `supplier`, `tanggal_masuk`, `keterangan`, `created_at`, `updated_at`) VALUES (7, 16, 'BM-531099', 'kaos polos 123', 20, 100.00, 'galaxi', '2025-10-31', 'tes', '2025-11-01 02:47:56', '2025-11-01 02:47:56');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
