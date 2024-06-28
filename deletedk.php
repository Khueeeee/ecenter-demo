<?php
include "connect.php";
$id = $_GET["id"];
$sql1 = "delete from dangkylich WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
header("location:dangkylich.php");
?>