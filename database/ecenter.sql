-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 05, 2024 lúc 11:00 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ecenter`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangkylich`
--

CREATE TABLE `dangkylich` (
  `id` int(11) NOT NULL,
  `id_gv` int(11) NOT NULL,
  `id_lop` int(11) NOT NULL,
  `thoigianhoc` varchar(255) NOT NULL,
  `cahoc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dangkylich`
--

INSERT INTO `dangkylich` (`id`, `id_gv`, `id_lop`, `thoigianhoc`, `cahoc`) VALUES
(17, 30, 21, 'Thứ 2 - Thứ 4', 'Buổi chiều'),
(18, 30, 23, 'Thứ 3 - Thứ 5', 'Buổi sáng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangkylich_gv`
--

CREATE TABLE `dangkylich_gv` (
  `id` int(11) NOT NULL,
  `id_gv` int(11) NOT NULL,
  `id_lop` int(11) NOT NULL,
  `thoigianhoc` varchar(255) NOT NULL,
  `cahoc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giangvien`
--

CREATE TABLE `giangvien` (
  `id` int(11) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `tuoi` int(11) NOT NULL,
  `anh` char(100) NOT NULL,
  `gioitinh` varchar(255) NOT NULL,
  `trinhdo` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodienthoai` varchar(10) NOT NULL,
  `gmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giangvien`
--

INSERT INTO `giangvien` (`id`, `hoten`, `tuoi`, `anh`, `gioitinh`, `trinhdo`, `diachi`, `sodienthoai`, `gmail`) VALUES
(29, 'Mr. Ping', 25, 'images/ping.jpg', 'Nam', 'Thạc sĩ', 'Hà Nội', '0123123123', 'ping@gmail.com'),
(30, 'Mr. Lee', 28, 'images/lee.jpg', 'Nam', 'Tiến sĩ', 'Thái Bình', '0125478965', 'lee@gmail.com'),
(32, 'Ms. Elsa', 23, 'images/staff169_6.jpg', 'Nữ', 'Tiến sĩ', 'Hải Phòng', '0123456789', 'elsa@gmail.com');

--
-- Bẫy `giangvien`
--
DELIMITER $$
CREATE TRIGGER `teacher_after_delete` AFTER DELETE ON `giangvien` FOR EACH ROW BEGIN
    -- Xóa thông tin liên kết trong bảng taikhoan_gv
    DELETE FROM taikhoan_gv
    WHERE id_gv = OLD.id;
    
    -- Xóa tài khoản của giảng viên
    DELETE FROM taikhoan
    WHERE username = OLD.gmail;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `teacher_after_update` AFTER UPDATE ON `giangvien` FOR EACH ROW BEGIN
    -- Cập nhật thông tin tài khoản
    UPDATE taikhoan
    SET username = NEW.gmail
    WHERE username = OLD.gmail;
    
    -- Cập nhật thông tin liên kết trong bảng taikhoan_gv
    -- Giả sử rằng email là duy nhất và có thể dùng để xác định tài khoản
    UPDATE taikhoan_gv
    SET id_gv = NEW.id
    WHERE id_user = (SELECT id FROM taikhoan WHERE username = NEW.gmail);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocsinh`
--

CREATE TABLE `hocsinh` (
  `id` int(11) NOT NULL,
  `anh` varchar(255) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `diemdauvao` float NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sdt` varchar(10) NOT NULL,
  `trangthai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hocsinh`
--

INSERT INTO `hocsinh` (`id`, `anh`, `hoten`, `diemdauvao`, `diachi`, `sdt`, `trangthai`) VALUES
(30, 'duckie.jpg', 'Bùi Minh Khuê', 4.5, 'Hải Phòng', '0123456781', 'Đang học'),
(33, 'duon.jpg', 'Cao Thị Hoàng Dương', 500, 'Hải Phòng', '0123456781', 'Đang học'),
(34, 'thao.jpg', 'Nguyễn Thu Thảo', 555, 'Hải Phòng', '0123456788', 'Đang học'),
(35, 'phuong.jpg', 'Bùi Thu Phương', 5.5, 'Thái Bình', '0123456781', 'Đang học'),
(37, 'images/pic-1.jpg', 'Đinh Thu Hằng', 500, 'Hải Phòng', '0123456781', 'Đang học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoahoc`
--

CREATE TABLE `khoahoc` (
  `id` int(11) NOT NULL,
  `tenkhoahoc` varchar(255) NOT NULL,
  `solophoc` int(11) DEFAULT 0,
  `anh` char(50) DEFAULT NULL,
  `noidung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoahoc`
--

INSERT INTO `khoahoc` (`id`, `tenkhoahoc`, `solophoc`, `anh`, `noidung`) VALUES
(8, 'TOEIC', 2, 'images/toeic.jpg', 'Khóa học Toeic từ cơ bản đến nâng cao\r\n'),
(9, 'IELTS', 1, 'images/ielts.webp', 'Khóa học ielts la la la');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lophoc`
--

CREATE TABLE `lophoc` (
  `id` int(11) NOT NULL,
  `tenlop` varchar(255) NOT NULL,
  `id_khoahoc` int(11) NOT NULL,
  `batdau` date NOT NULL,
  `ketthuc` date NOT NULL,
  `sohocvien` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lophoc`
--

INSERT INTO `lophoc` (`id`, `tenlop`, `id_khoahoc`, `batdau`, `ketthuc`, `sohocvien`) VALUES
(21, 'Pre Ielts tháng 6', 9, '2024-06-04', '2024-07-04', 3),
(23, 'Toeic tháng 6', 8, '2024-06-04', '2024-06-20', 2),
(25, 'Pro Toeic 6', 8, '2024-06-09', '2024-09-08', 0);

--
-- Bẫy `lophoc`
--
DELIMITER $$
CREATE TRIGGER `update_solophoc_after_delete` AFTER DELETE ON `lophoc` FOR EACH ROW BEGIN
	UPDATE khoahoc
	SET solophoc = (SELECT COUNT(*) FROM lophoc WHERE lophoc.id_khoahoc = OLD.id_khoahoc)
	WHERE id = OLD.id_khoahoc;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_solophoc_after_insert` AFTER INSERT ON `lophoc` FOR EACH ROW BEGIN
	UPDATE khoahoc
	SET solophoc = (SELECT COUNT(*) FROM lophoc WHERE lophoc.id_khoahoc = NEW.id_khoahoc)
	WHERE id = NEW.id_khoahoc;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_solophoc_after_update` AFTER UPDATE ON `lophoc` FOR EACH ROW BEGIN
	UPDATE khoahoc
	SET solophoc = (SELECT COUNT(*) FROM lophoc WHERE lophoc.id_khoahoc = NEW.id_khoahoc)
	WHERE id = NEW.id_khoahoc;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop_hs`
--

CREATE TABLE `lop_hs` (
  `id` int(11) NOT NULL,
  `id_lop` int(11) NOT NULL,
  `id_hs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop_hs`
--

INSERT INTO `lop_hs` (`id`, `id_lop`, `id_hs`) VALUES
(11, 21, 30),
(19, 23, 33),
(20, 23, 34),
(21, 21, 35),
(24, 21, 37);

--
-- Bẫy `lop_hs`
--
DELIMITER $$
CREATE TRIGGER `class_after_delete` AFTER DELETE ON `lop_hs` FOR EACH ROW BEGIN
    UPDATE lophoc SET sohocvien = (SELECT COUNT(*) from lop_hs WHERE lop_hs.id_lop = OLD.id_lop)
    WHERE id = OLD.id_lop;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `class_after_insert` AFTER INSERT ON `lop_hs` FOR EACH ROW BEGIN
    UPDATE lophoc SET sohocvien = (SELECT COUNT(*) FROM lop_hs WHERE lop_hs.id_lop = NEW.id_lop)
	WHERE id = NEW.id_lop;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_student_class` AFTER UPDATE ON `lop_hs` FOR EACH ROW BEGIN
    IF OLD.id_lop <> NEW.id_lop THEN
        UPDATE lophoc SET sohocvien = (SELECT COUNT(*) from lop_hs WHERE lop_hs.id_lop = OLD.id_lop)
    WHERE id = OLD.id_lop;
        UPDATE lophoc SET sohocvien = (SELECT COUNT(*) from lop_hs WHERE lop_hs.id_lop = NEW.id_lop)
    WHERE id = NEW.id_lop;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `passs` varchar(100) NOT NULL,
  `typee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `username`, `passs`, `typee`) VALUES
(1, 'admin', '$2y$10$aEOjV4h8UOdIMsDYxeTB8OO0qQgs7dp0WA.6V1DPPuHRuilnBvnBy', 0),
(29, 'ping@gmail.com', '$2y$10$B2I9XF4OLRkDC0Ydjqpgl.Dqo17NqdtSto09q2B1E5LnRLKWlVvJS', 1),
(30, 'lee@gmail.com', '$2y$10$Dt1ESQ55hfVirI6tZdmxCOUJXTy2h0WtUCH61/pXsp7Oy0oM0ztc.', 1),
(32, 'elsa@gmail.com', '$2y$10$xXqzHU38KVeXFgN2w2V9AO6jqGLivv3/QCAcJ9436dlKmY2cWWQt2', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan_gv`
--

CREATE TABLE `taikhoan_gv` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_gv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan_gv`
--

INSERT INTO `taikhoan_gv` (`id`, `id_user`, `id_gv`) VALUES
(20, 29, 29),
(21, 30, 30),
(23, 32, 32);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dangkylich`
--
ALTER TABLE `dangkylich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_lopdk` (`id_lop`),
  ADD KEY `fk_id_gvdk` (`id_gv`);

--
-- Chỉ mục cho bảng `dangkylich_gv`
--
ALTER TABLE `dangkylich_gv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_lopp` (`id_lop`),
  ADD KEY `fk_id_giv` (`id_gv`);

--
-- Chỉ mục cho bảng `giangvien`
--
ALTER TABLE `giangvien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_kh` (`id_khoahoc`);

--
-- Chỉ mục cho bảng `lop_hs`
--
ALTER TABLE `lop_hs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lophs` (`id_lop`),
  ADD KEY `fk_hslop` (`id_hs`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `taikhoan_gv`
--
ALTER TABLE `taikhoan_gv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_user` (`id_user`),
  ADD KEY `fk_id_gvien` (`id_gv`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dangkylich`
--
ALTER TABLE `dangkylich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `dangkylich_gv`
--
ALTER TABLE `dangkylich_gv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `giangvien`
--
ALTER TABLE `giangvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `lop_hs`
--
ALTER TABLE `lop_hs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `taikhoan_gv`
--
ALTER TABLE `taikhoan_gv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dangkylich`
--
ALTER TABLE `dangkylich`
  ADD CONSTRAINT `fk_id_gvdk` FOREIGN KEY (`id_gv`) REFERENCES `giangvien` (`id`),
  ADD CONSTRAINT `fk_id_lopdk` FOREIGN KEY (`id_lop`) REFERENCES `lophoc` (`id`);

--
-- Các ràng buộc cho bảng `dangkylich_gv`
--
ALTER TABLE `dangkylich_gv`
  ADD CONSTRAINT `fk_id_giv` FOREIGN KEY (`id_gv`) REFERENCES `giangvien` (`id`),
  ADD CONSTRAINT `fk_id_lopp` FOREIGN KEY (`id_lop`) REFERENCES `lophoc` (`id`);

--
-- Các ràng buộc cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD CONSTRAINT `fk_id_kh` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id`);

--
-- Các ràng buộc cho bảng `lop_hs`
--
ALTER TABLE `lop_hs`
  ADD CONSTRAINT `fk_hslop` FOREIGN KEY (`id_hs`) REFERENCES `hocsinh` (`id`),
  ADD CONSTRAINT `fk_lophs` FOREIGN KEY (`id_lop`) REFERENCES `lophoc` (`id`);

--
-- Các ràng buộc cho bảng `taikhoan_gv`
--
ALTER TABLE `taikhoan_gv`
  ADD CONSTRAINT `fk_id_gvien` FOREIGN KEY (`id_gv`) REFERENCES `giangvien` (`id`),
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `taikhoan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
