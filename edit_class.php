<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$id = $_GET['id'];
$sql1 = "select * from lophoc where id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$id_khoahoc =  $result['id_khoahoc'];
if(!empty($_POST['submit'])){
    if(isset($_POST['tenlop'])){
        $tenlop = $_POST['tenlop'];
        $batdau = $_POST["batdau"];
        $ketthuc = $_POST["ketthuc"];
        $sql="update lophoc set tenlop = '$tenlop', batdau = '$batdau',
        ketthuc = '$ketthuc' where id = '$id'";
        $stmt = $conn ->prepare($sql);
        $query = $stmt->execute();
        if($query){
            header("location:class.php?id=". $id_khoahoc);
        }else{
            echo "Cập nhật thất bại, vui lòng thử lại";
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
   <title>Lớp học</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

        <h1>Chỉnh sửa lớp học</h1>
        <?php
    include "sidebar_ad.php";
    ?>
<section class="addcourse">
<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên lớp học</label>
            <input type="text" name="tenlop" class="form-control" value="<?php echo $result['tenlop']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="batdau" value="<?php echo $result['batdau']; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="ketthuc" value="<?php echo $result['ketthuc']; ?>">
        </div>
        <div class="them">
            <button type="submit" name="submit" value="submit" class="btn">Sửa</button>
        </div>
        </form>
    </div>
</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>
  
</body>
</html>