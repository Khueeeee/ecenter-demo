<?php
    include"connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
   $sql = "select * from dangkylich";
   $stmt = $conn->prepare($sql);
   $query = $stmt->execute();

   $sql1 = "select hoten FROM giangvien ";
   $stmt1 = $conn->prepare($sql1);
   $query1 = $stmt1->execute();
   $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

   $sql2 = "select tenlop FROM lophoc ";
   $stmt2 = $conn->prepare($sql2);
   $query2 = $stmt2->execute();
   $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

   if (!empty($_POST["submit"])) {
      if (isset($_POST["teacher"]) && isset($_POST["lophoc"]) && isset($_POST["time-session"]) && isset($_POST["study-session"])) {
          $giangvien = $_POST["teacher"];
          $lophoc = $_POST["lophoc"];
          $thoigianhoc = $_POST["time-session"];
          $cahoc = $_POST["study-session"];
  
          // Kiểm tra tồn tại giáo viên
          $sql1 = "SELECT id FROM giangvien WHERE hoten = '$giangvien'";
          $stmt1 = $conn->prepare($sql1);
          $stmt1->execute();
          $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
          if (!$row1) {
              echo "Giáo viên không tồn tại.";
              exit;
          }
          $id_gv = $row1['id'];
  
          // Kiểm tra tồn tại lớp học
          $sql2 = "SELECT id FROM lophoc WHERE tenlop = '$lophoc'";
          $stmt2 = $conn->prepare($sql2);
          $stmt2->execute();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          if (!$row2) {
              echo "Lớp học không tồn tại.";
              exit;
          }
          $id_lop = $row2['id'];


  
          // Kiểm tra trùng lặp thông tin
          $sql_check = "SELECT COUNT(*) FROM dangkylich WHERE id_gv = '$id_gv' and id_lop = '$id_lop' and thoigianhoc = '$thoigianhoc' and cahoc ='$cahoc'";
          $stmt_check = $conn->prepare($sql_check);
          $stmt_check->execute();
          $count = $stmt_check->fetchColumn();
          if ($count > 0) {
              echo "Thông tin đã tồn tại trong bảng dangky";
          }
          else{
            $sql_insert="insert into dangkylich(id_gv, id_lop, thoigianhoc, cahoc) values('$id_gv','$id_lop','$thoigianhoc','$cahoc')";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->execute();
          }
      if($query){
          header("location:dangkylich.php");
      }else{
          echo "Thêm thất bại, vui lòng thử lại!";
      }
  }
}
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
      function pheduyet(){
         location.href ="dkgv.php";
      }
   </script>

</head>
<body>

   <header class="header">
   
      <section class="flex">
         <h1>Lịch dạy</h1>
   
         <?php
    include "sidebar_ad.php";
    ?>

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
        <h3>Đăng ký lịch giảng dạy</h3>
        <label>Giảng viên</label>
        <select id="teacher" name="teacher" required  required maxlength="50" class="box">
         <option value=""></option>
            <?php foreach ($result1 as $giangvien): ?>
               <option><?php echo $giangvien['hoten']; ?></option>
            <?php endforeach ?>
        </select>
        <label>Lớp học</label>
        <select id="time-session" name="lophoc" required  required maxlength="50" class="box">
        <option value=""></option> 
            <?php foreach ($result2 as $lophoc): ?>
               <option><?php echo $lophoc['tenlop']; ?></option>
            <?php endforeach ?>
       </select>
        <label>Thời gian học</label>
        <select id="time-session" name="time-session" required  required maxlength="50" class="box">
            <option value=""></option>
           <option >Thứ 2 - Thứ 4</option>
           <option >Thứ 3 - Thứ 5</option>
           <option>Thứ 7 - Chủ nhật</option>
       </select>
        <label  required maxlength="50">Ca học</label>
        <select id="study-session" name="study-session" required  required maxlength="50" class="box">
            <option value=""></option>   
            <option >Buổi sáng</option>
           <option >Buổi chiều</option>
           <option >Buổi tối</option>
       </select>
        <input type="submit" value="Đăng ký" class="inline-btn" name="submit">
        
      </form>
    </div>
    <button type="button" value="Phê duyệt đăng ký mới" class="inline-btn" name="pheduyet" onclick="pheduyet()" style="margin-bottom: 15px">Phê duyệt đăng ký mới</button>
    <table class="table table-danger table-striped">
        <thead>
          <tr>
            <th>Giảng viên</th>
            <th>Lớp</th>
            <th>Lịch giảng dạy</th>
            <th>Ca dạy</th>
            <th>Sửa</th>
            <th>Xóa</th>
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
                                    echo '<td><a href="editdk.php?id=' . $row['id'] . '"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i></a></td>';
                                    echo '<td><a href="deletedk.php?id=' . $row['id'] . '"><i class="fa-solid fa-trash" style="color: #000000;"></i></a></td>';
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