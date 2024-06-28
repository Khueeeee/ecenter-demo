<?php
    include"connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    $id = $_GET['id'];
    $sql = "select * FROM dangkylich WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $gtri = $stmt->fetch(PDO::FETCH_ASSOC);

    $fk_id_gv = $gtri['id_gv'];
    $sql3 = "select hoten FROM giangvien WHERE id = '$fk_id_gv' ";
    $stmt3 = $conn->prepare($sql3);
    $query3= $stmt3->execute();
    $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $gvhientai = $result3['hoten'];

    $fk_id_lop = $gtri['id_lop'];
    $sql4 = "select tenlop FROM lophoc WHERE id = '$fk_id_lop' ";
    $stmt4 = $conn->prepare($sql4);
    $query4= $stmt4->execute();
    $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    $lophientai = $result4['tenlop'];

    $tgianhocht = $gtri['thoigianhoc'];
    $cahocht = $gtri['cahoc'];

    $sql1 = "select hoten FROM giangvien ";
    $stmt1 = $conn->prepare($sql1);
    $query1 = $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "select tenlop FROM lophoc ";
    $stmt2 = $conn->prepare($sql2);
    $query2 = $stmt2->execute();
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($_POST["submit"])) {
        if (isset($_POST["teacher"]) && isset($_POST["lophoc"]) && isset($_POST["time-session"]) && isset($_POST["study-session"])){
            $giangvien = $_POST["teacher"];
            $sql1 = "select * from giangvien where hoten='$giangvien'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $id_gv = $row1['id'];
  
            $lophoc = $_POST["lophoc"];
            $sql2 = "select * from lophoc where tenlop='$lophoc'";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $id_lop = $row2['id'];
    
            $thoigianhoc = $_POST["time-session"];
            $cahoc = $_POST["study-session"];
  
        $sql = "update dangkylich set id_gv = '$id_gv',id_lop = '$id_lop',thoigianhoc ='$thoigianhoc' ,cahoc = '$cahoc' where id='$id'";
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute(); 
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
   <title>Thay đổi lịch dạy</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script>
        function huy(){
            location.href = 'dangkylich.php';
        }
    </script>

</head>
<body>

   <header class="header">
   
      <section class="flex">
         <h1>Chỉnh sửa lịch đăng ký</h1>
   
         <?php
    include "sidebar_ad.php";
    ?>

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
      <h3>Thay đổi lịch giảng dạy</h3>
      <label>Giảng viên</label>
      <select id="teacher" name="teacher" required maxlength="50" class="box" readonly>
         <option></option>
         <?php foreach ($result1 as $giangvien): ?>
            <option <?php if ($giangvien['hoten'] == $gvhientai) echo 'selected'; ?>><?php echo $giangvien['hoten']; ?></option>
        <?php endforeach ?>
      </select>

      <label>Lớp học</label>
      <select id="time-session" name="lophoc" required maxlength="50" class="box">
         <option></option>
         <?php foreach ($result2 as $lophoc): ?>
               <option <?php if ($lophoc['tenlop'] == $lophientai) echo 'selected'; ?>><?php echo $lophoc['tenlop']; ?></option>
         <?php endforeach ?>
      </select>

      <label>Thời gian học</label>
      <select id="time-session" name="time-session" required maxlength="50" class="box">
         <option></option>
         <option <?php if ($tgianhocht == 'Thứ 2 - Thứ 4') echo 'selected'; ?>>Thứ 2 - Thứ 4</option>
         <option <?php if ($tgianhocht == 'Thứ 3 - Thứ 5') echo 'selected'; ?>>Thứ 3 - Thứ 5</option>
         <option <?php if ($tgianhocht == 'Thứ 7 - Chủ nhật') echo 'selected'; ?>>Thứ 7 - Chủ nhật</option>
      </select>

      <label>Ca học</label>
      <select id="study-session" name="study-session" required maxlength="50" class="box">
         <option></option>
         <option <?php if ($cahocht == 'Buổi sáng') echo 'selected'; ?>>Buổi sáng</option>
         <option <?php if ($cahocht == 'Buổi chiều') echo 'selected'; ?>>Buổi chiều</option>
         <option <?php if ($cahocht == 'Buổi tối') echo 'selected'; ?>>Buổi tối</option>
      </select>

      <input type="submit" value="Lưu" class="inline-btn" name="submit">
      <button type="button" class="inline-btn" onclick="huy()">Hủy</button>
   </form>

    </div>
    </section>
<script src="js/script.js">
</script>
</body>
</html>