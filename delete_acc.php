<?php
include "connect.php";
$id = $_GET["id"];

// Lấy id_gv từ kết quả truy vấn
$sql1 = "SELECT id_gv FROM taikhoan_gv WHERE id_user = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
$result1 = $stmt->fetch(PDO::FETCH_ASSOC);
$id_gv = $result1['id_gv'];

// Xóa các lịch dạy liên quan đến các lớp học của khóa học
$sql3 = "DELETE FROM dangkylich WHERE id_gv = :id_gv";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':id_gv', $id_gv);
$query3 = $stmt3->execute();

$sql4 = "DELETE FROM taikhoan_gv WHERE id_user = '$id'";
$stmt4 = $conn->prepare($sql4);
$query4 = $stmt4->execute();

// Xóa tài khoản giảng viên và thông tin liên quan
$sql2 = "DELETE FROM taikhoan WHERE id = '$id'";
$stmt2 = $conn->prepare($sql2);
$query2 = $stmt2->execute();

$sql = "DELETE FROM giangvien WHERE id = :id_gv";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_gv', $id_gv);
$query = $stmt->execute();

header("location:accounts.php");
?>