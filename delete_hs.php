<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT tenlop from lophoc join lop_hs on lop_hs.id_lop = lophoc.id 
            join hocsinh on lop_hs.id_hs = hocsinh.id 
            WHERE hocsinh.id=:id_hs";
$stmt1 = $conn->prepare($sql);
$stmt1->execute(['id_hs' => $id]);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
if ($stmt1->rowCount() != 0) {
    $sql2 = "DELETE FROM lop_hs WHERE id_hs = '$id'";
    $stmt2 = $conn->prepare($sql2);
    $query = $stmt2->execute();
}      
$sql1 = "DELETE FROM hocsinh WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
header("location:index_hs.php");
?>