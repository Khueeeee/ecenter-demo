<?php
include "connect.php";
$id = $_GET['id'];
$sql1 = "select * FROM dangkylich_gv WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
$gtri = $stmt->fetch(PDO::FETCH_ASSOC);
$fk_id_gv = $gtri['id_gv'];
$fk_id_lop = $gtri['id_lop'];
$tgianhocht = $gtri['thoigianhoc'];
$cahocht = $gtri['cahoc'];
$sql2 = "delete from dangkylich_gv where id = '$id'";
$stmt2 = $conn->prepare($sql2);
$query = $stmt2->execute();
if ($query) {
    header("location:dangkylich.php"); 
    } else {
    echo "Cập nhật thất bại, vui lòng thử lại";
    }
?>