<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$user_id = $_SESSION['id_user'] ;

$sql1 = "select * from giangvien where id = (select id_gv from taikhoan_gv where id_user = $user_id)";
$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$result = $stmt1->fetch(PDO::FETCH_ASSOC);
$gv_hoten = $result['hoten'];
$id = $result['id'];
$name = "";
    if(isset($_POST["ten"])) {
        $name = $_POST["ten"];
    }

$sql="SELECT * FROM giangvien where hoten like '%$name%'";
$stmt=$conn->prepare($sql);
$query=$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giảng viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
   
   <section class="flex">

     <h1>Giảng viên</h1>

     <?php
   include "sidebar.php";
   ?>

<section class="teachers">

<div class="tieude">
<form action="index_gv.php" method="post" class="search-tutor" enctype="multipart/form-data">
       <input type="text" name="ten" placeholder="Tìm kiếm giáo viên" maxlength="100">
       <button type="submit" class="fas fa-search" name="search_tutor"></button>
      </form>
   </div>

<div class="box-container">

        <?php
            $columnCount =0;
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="box">';
            echo '<div class="tutor">';
            echo '<img src="' . $row['anh'] . '">';
            echo '<div>';
            echo '<h3>' . $row['hoten'] . '</h3>';
            echo '<span>' . $row['trinhdo'] . '</span>';
            echo '</div>';
            echo '</div>';
            echo '<p>Tuổi: <span>' . $row['tuoi'] . '</span></p>';
            echo '<p>Giới tính: <span>' . $row['gioitinh'] . '</span></p>';
            echo '<p>Địa chỉ: <span>' . $row['diachi'] . '</span></p>';
            echo '<p>Gmail: <span>' . $row['gmail'] . '</span></p>';
            echo '<p>Số điện thoại: <span>' . $row['sodienthoai'] . '</span></p>';
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
            location.href = 'them_gv.php';
        }
    </script>
</body>
</html>