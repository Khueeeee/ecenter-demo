<?php
    include"connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    $sql = "select * from dangkylich_gv";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng ký lịch dạy</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script>
      function back(){
         location.href ="dangkylich.php";
      }
      function duyet(){
         alert("Đã duyệt!");
      }
      function tuchoi(){
        alert("Đã từ chối!");
      }
   </script>

</head>
<body>

   <header class="header">
   
      <section class="flex">
   
         <h1>Phê duyệt lịch dạy</h1>
   
         <?php
    include "sidebar_ad.php";
    ?>
<section class="contact">
        <center><h1 style="margin-bottom: 20px">Đăng ký mới</h1></center>
        <button type="button" value="Quay lại" class="inline-btn" name="pheduyet" onclick="back()" style="margin-bottom: 15px">Quay lại</button>
    <table class="table table-danger table-striped">
        <thead>
          <tr>
            <th>Giảng viên</th>
            <th>Lớp</th>
            <th>Lịch giảng dạy</th>
            <th>Ca dạy</th>
            <th>Duyệt</th>
            <th>Từ chối</th>
          </tr>
        </thead>
        <tbody>
            <tr id="tr1">
                <?php
                    $columnCount =0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $sql1 = "SELECT hoten FROM giangvien WHERE id = :id_gv";
                        $stmt1 = $conn->prepare($sql1);
                        $stmt1->execute(['id_gv' => $row['id_gv']]);
                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $sql2 = "SELECT tenlop FROM lophoc WHERE id = :id_lop";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute(['id_lop' => $row['id_lop']]);
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    echo '<tr>';
                                    echo '<td>' . $row1['hoten'] . '</td>';
                                    echo '<td>' . $row2['tenlop'] . '</td>';
                                    echo '<td>' . $row['thoigianhoc'] . '</td>';
                                    echo '<td>' . $row['cahoc'] . '</td>';
                                    echo '<td><a href="duyetdk.php?id=' . $row['id'] . '"><i class="fa-solid fa-check" style="color: #000000;" onclick="duyet()"></i></a></td>';
                                    echo '<td><a href="tuchoidk.php?id=' . $row['id'] . '"><i class="fa-solid fa-x" style="color: #000000;"onclick="tuchoi()"></i></a></td>';
                                    echo '</tr>';
                                $columnCount++;
                                if ($columnCount >= 8) {
                                    echo '</tr>'; 
                                            echo '<tr id="tr1">'; 
                                            $columnCount = 0; 
                                }
                            }
                           ?>
                           </tr>
                    </table>
</section>
<script src="js/script.js"></script>
</body>
</html>