<?php
    include "connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    $sql = "SELECT COUNT(*) as count FROM khoahoc";
    $stmt=$conn->prepare($sql);
    $query=$stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql1 = "SELECT COUNT(*) as count FROM giangvien";
    $stmt=$conn->prepare($sql1);
    $query=$stmt->execute();
    $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql2 = "SELECT COUNT(*) as count FROM hocsinh";
    $stmt=$conn->prepare($sql2);
    $query=$stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tài khoản người dùng</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

        <h1>Dashboard</h1>

      <?php include "sidebar_ad.php"; ?>

<section class="user-profile">


   <div class="info">
   
      <div class="box-container" >
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-graduation-cap"></i>
               <div>
                  <span><?php echo $result['count']; ?></span>
                  <p>Khóa học</p>
               </div>
            </div>
            <a href="course.php" class="inline-btn">Xem chi tiết</a>
         </div>
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-chalkboard-user"></i>
               <div>
                  <span><?php echo $result1['count']; ?></span>
                  <p>Giảng viên</p>
               </div>
            </div>
            <a href="giangvien.php" class="inline-btn">Xem chi tiết</a>
         </div>
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-user-pen"></i>
               <div>
                  <span><?php echo $result2['count']; ?></span>
                  <p>Học sinh</p>
               </div>
            </div>
            <a href="hocsinh.php" class="inline-btn">Xem chi tiết</a>
         </div>
   
      </div>
   </div>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

   
</body>
</html>