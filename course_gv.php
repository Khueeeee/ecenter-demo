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

    $tim = "";
    if(isset($_POST["tim"])) {
        $tim = $_POST["tim"];
    }
    $sql = "SELECT * FROM khoahoc WHERE tenkhoahoc LIKE '%$tim%'";
    $stmt=$conn->prepare($sql);
    $query=$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Khóa học</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

     <h1>Khóa học</h1>

    <?php
    include "sidebar.php";
    ?>

<section class="courses">
    <div class="tieude">
     <form action="" method="post" class="search-tutor">
      <input type="text" name="tim" placeholder="Tìm kiếm khóa học" maxlength="100">
      <button type="submit" class="fas fa-search" name="search_tutor"></button>
     </form>
    </div>
    
<div class="container">
    <div class="box">
        <div class="row">
        <?php
                if($query){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                ?>
            <div class="col-4 gx-5">
                <div class="card">
                    <img src="<?php echo $row["anh"]?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["tenkhoahoc"]?></h5>                        
                        <div class="card-text">
                            <p><?php echo $row["noidung"]?></p>
                            <ul>
                                <li>Số lớp: <?php echo $row["solophoc"]?></li>
                            </ul>
                        </div>
                        <a href="class_gv.php?id=<?php echo $row["id"]?>" class="btn">Xem lớp học</a>
                    </div>
                 </div>
            </div>
            <?php
                    }
                }
                ?>
        </div>
    </div>
</div>

</div>
</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>
  
</body>
</html>