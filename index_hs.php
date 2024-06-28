<?php
include"connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$name = "";
    if(isset($_POST["ten"])) {
        $name = $_POST["ten"];
    }

$sql="SELECT * FROM hocsinh where hoten like '%$name%'";
$stmt=$conn->prepare($sql);
$query=$stmt->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học sinh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
   
   <section class="flex">

      <h1 class="logo">Học sinh</h1>

      <?php
    include "sidebar_ad.php";
    ?>

<section class="teachers">

<div class="tieude">
      <form action="index_hs.php" method="post" class="search-tutor" enctype="multipart/form-data">
       <input type="text" name="ten" placeholder="Tìm kiếm học sinh" maxlength="100">
       <button type="submit" class="fas fa-search" name="search_tutor"></button>
      </form>
      <button type="button" class="inline-btn" onclick="them()">Thêm học sinh</button>
   </div>

<div class="box-container">

        <?php
            $columnCount =0;
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $sql1 = "SELECT tenlop from lophoc join lop_hs on lop_hs.id_lop = lophoc.id 
            join hocsinh on lop_hs.id_hs = hocsinh.id 
                  WHERE hocsinh.id=:id_hs";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute(['id_hs' => $row['id']]);
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            
            echo '<div class="box">';
            echo '<div class="tutor">';
            echo '<img src="' . $row['anh'] . '">';
            echo '<div>';
            echo '<h3>' . $row['hoten'] . '</h3>';
            echo '<span>Điểm đầu vào: ' . $row['diemdauvao'] . '</span>';
            echo '</div>';
            echo '</div>';
            if ($stmt1->rowCount() === 0) {
               echo '<p>Tên lớp: <span>Chưa có lớp học</span></p>';
            } else {
               echo '<p>Tên lớp: <span>' . $row1['tenlop'] . '</span></p>';
            }
            echo '<p>Địa chỉ: <span>' . $row['diachi'] . '</span></p>';
            echo '<p>Số điện thoại: <span>' . $row['sdt'] . '</span></p>';
            echo '<p>Trạng thái: <span>' . $row['trangthai'] . '</span></p>';
            echo '<a href="edit_hs.php?id=' . $row['id'] . '" class="inline-btn">Sửa</a>';
            echo '&ensp;';
            echo '<a href="delete_hs.php?id=' . $row['id'] . '" class="inline-btn">Xóa</a>';
            echo '</div>';
            $columnCount++;
            if ($columnCount >= 5) {
                        $columnCount = 0; 
            }
        }
        ?>
  </div>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

    <script>
        function them() {
            location.href = 'them_hs.php';
        }
    </script>
</body>
</html>