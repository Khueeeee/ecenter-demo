<?php
include "connect.php";
$id_khoahoc = $_GET["id"];

// Xóa các lịch dạy liên quan đến các lớp học của khóa học
$sql3 = "DELETE FROM dangkylich WHERE id_lop IN (SELECT id FROM lophoc WHERE id_khoahoc = '$id_khoahoc')";
$stmt3 = $conn->prepare($sql3);
$query3 = $stmt3->execute();

// Kiểm tra xem câu lệnh trên có thành công không
if($query3){
    // Xóa các liên kết giữa học sinh và lớp học của khóa học
    $sql = "DELETE FROM lop_hs WHERE id_lop IN (SELECT id FROM lophoc WHERE id_khoahoc = '$id_khoahoc')";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();

    // Kiểm tra xem câu lệnh trên có thành công không
    if($query){
        // Xóa các lớp học thuộc khóa học
        $sql1 = "DELETE FROM lophoc WHERE id_khoahoc = '$id_khoahoc'";
        $stmt1 = $conn->prepare($sql1);
        $query1 = $stmt1->execute();

        // Kiểm tra xem câu lệnh trên có thành công không
        if($query1){
            // Cuối cùng, xóa khóa học
            $sql2 = "DELETE FROM khoahoc WHERE id = '$id_khoahoc'";
            $stmt2 = $conn->prepare($sql2);
            $query2 = $stmt2->execute();

            // Kiểm tra xem câu lệnh trên có thành công không
            if($query2){
                header("location:course.php");
            } else {
                echo "Xóa khóa học thất bại, vui lòng thử lại!!!";
            }
        } else {
            echo "Xóa lớp học thất bại, vui lòng thử lại!!!";
        }
    } else {
        echo "Xóa liên kết học sinh và lớp học thất bại, vui lòng thử lại!!!";
    }
} else {
    echo "Xóa lịch dạy thất bại, vui lòng thử lại!!!";
}
?>