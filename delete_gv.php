<?php
include "connect.php";
$id = $_GET["id"];

// Xóa các lịch dạy liên quan đến các lớp học của khóa học
$sql3 = "DELETE FROM dangkylich WHERE id_gv = '$id'";
$stmt3 = $conn->prepare($sql3);
$query3 = $stmt3->execute();

$sql2 = "DELETE FROM taikhoan_gv WHERE id_gv = '$id'";
$stmt = $conn->prepare($sql2);
$query = $stmt->execute();

$sql1 = "DELETE FROM giangvien WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
header("location:index_gv.php");

?>