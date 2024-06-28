<?php
include "connect.php";
$id = $_GET["id"];

$sql2 = "DELETE FROM dangkylich WHERE id_lop = '$id'";
$stmt = $conn->prepare($sql2);
$query = $stmt->execute();

$sql = "DELETE FROM lop_hs WHERE id_lop = '$id'";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();

$sql1 = "DELETE FROM lophoc WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
header("location:course.php");
?>