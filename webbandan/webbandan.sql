-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 23, 2025 lúc 06:57 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbandan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `instrument`
--

CREATE TABLE `instrument` (
  `ma` int(11) NOT NULL,
  `ten` varchar(50) NOT NULL,
  `xuatXu` varchar(50) DEFAULT NULL,
  `giaThanh` decimal(15,2) NOT NULL,
  `hang` varchar(100) DEFAULT NULL,
  `hinhAnh` varchar(255) DEFAULT NULL,
  `moTa` text DEFAULT NULL,
  `loaiDan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `instrument`
--

INSERT INTO `instrument` (`ma`, `ten`, `xuatXu`, `giaThanh`, `hang`, `hinhAnh`, `moTa`, `loaiDan_id`) VALUES
(4, 'TAYLOR PS14CE HONDURAN ROSEWOOD', 'North California ', 355050000.00, 'TAYLOR', '../uploads/headpat.gif', '', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaidan`
--

CREATE TABLE `loaidan` (
  `ma` int(11) NOT NULL,
  `tenLoai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaidan`
--

INSERT INTO `loaidan` (`ma`, `tenLoai`) VALUES
(1, 'Piano'),
(2, 'Organ'),
(3, 'Guitar'),
(4, 'Ukulele ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `ma` int(11) NOT NULL,
  `hoTen` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `soDienThoai` char(10) DEFAULT NULL CHECK (`soDienThoai` regexp '^[0-9]{10}$'),
  `diaChi` varchar(255) DEFAULT NULL,
  `phuongThucThanhToan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`ma`, `hoTen`, `email`, `matKhau`, `soDienThoai`, `diaChi`, `phuongThucThanhToan`) VALUES
(6, 'admin', 'admin@gmail.com', '$2y$10$b735MovrWL49iuiRMuSjlOfwMJUukc6aSGdL.hDqplp31WR3xI8V6', '0123456789', NULL, NULL),
(7, 'hehe', 'nag13032018@gmail.com', '$2y$10$ykg0aa94pD1wbziW4Rn7iOIqqjCkvbgzTiSESmE3le7Ty/4HgWe2i', '0123456789', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `instrument`
--
ALTER TABLE `instrument`
  ADD PRIMARY KEY (`ma`),
  ADD KEY `fk_instrument_loaidan` (`loaiDan_id`);

--
-- Chỉ mục cho bảng `loaidan`
--
ALTER TABLE `loaidan`
  ADD PRIMARY KEY (`ma`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`ma`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `instrument`
--
ALTER TABLE `instrument`
  MODIFY `ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `loaidan`
--
ALTER TABLE `loaidan`
  MODIFY `ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `instrument`
--
ALTER TABLE `instrument`
  ADD CONSTRAINT `fk_instrument_loaidan` FOREIGN KEY (`loaiDan_id`) REFERENCES `loaidan` (`ma`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
