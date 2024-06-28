<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$user_id = $_SESSION['id_user'] ;

$sql2 = "select * from taikhoan where id = $user_id";
$stmt2 = $conn->prepare($sql2);
$query = $stmt2->execute();
$result1 = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql1 = "select * from giangvien where id = (select id_gv from taikhoan_gv where id_user = $user_id)";
$stmt1 = $conn->prepare($sql1);
$query = $stmt1->execute();
$result = $stmt1->fetch(PDO::FETCH_ASSOC);
$gv_hoten = $result['hoten'];
$id = $result['id'];

if(!empty($_POST["submit"])){
    if(isset($_POST["hoten"]) && isset($_FILES["anh"]) && isset($_POST["tuoi"])
        && isset($_POST["gioitinh"]) && isset($_POST["trinhdo"]) && isset($_POST["diachi"]) 
        && isset($_POST["sodienthoai"]) && isset($_POST["gmail"]) ){
            $hoten = $_POST["hoten"];
            $tuoi = $_POST["tuoi"];
            $gioitinh = $_POST["gioitinh"];
            $trinhdo = $_POST["trinhdo"];
            $diachi = $_POST["diachi"];
            $sodienthoai = $_POST["sodienthoai"];
            $gmail = $_POST["gmail"];
        if(isset($_FILES['anh']) && $_FILES['anh']['error'] == 0){
            $anh = $_FILES['anh']['name'];
            $anh_tmp = $_FILES['anh']['tmp_name'];
            $folder = ''; 
            move_uploaded_file($anh_tmp, $folder.$anh);
        } else {
            $anh = $result['anh'];
        }
        if(isset($_POST["passs"])){
            $password = $_POST["passs"];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE taikhoan SET passs = '$hashed_password' where id = '$user_id'";
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();
        }
        $sql = "UPDATE giangvien SET hoten = '$hoten', anh = '$folder$anh', tuoi = '$tuoi' , gioitinh = '$gioitinh', trinhdo = '$trinhdo', diachi = '$diachi', sodienthoai = '$sodienthoai', gmail = '$gmail' where id = '$id'";
        $stmt = $conn->prepare($sql);
        $query = $stmt->execute();
        if($query){
            header("location:course_gv.php");
        }else{
            echo "Thêm thất bại, vui lòng thử lại!!!";
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
   <title>Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

   <header class="header">
   
      <section class="flex">
   
        <h1>Profile</h1>
   
   <?php
   include "sidebar.php";
   ?>

<section class="addcourse">


   <div class="container">
   
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Họ tên giảng viên</label>
            <input type="text" name="hoten" class="form-control" value="<?php echo $result['hoten']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tuổi</label>
            <input type="text" name="tuoi" class="form-control" value="<?php echo $result['tuoi']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Giới tính</label>
            <input type="text" name="gioitinh" class="form-control" value="<?php echo $result['gioitinh']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Trình độ</label>
            <input type="text" name="trinhdo" class="form-control" value="<?php echo $result['trinhdo']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Địa chỉ</label>
            <input type="text" name="diachi" class="form-control" value="<?php echo $result['diachi']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Địa chỉ gmail</label>
            <input type="text" name="gmail" class="form-control" value="<?php echo $result['gmail']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
            <input type="text" name="sodienthoai" class="form-control" value="<?php echo $result['sodienthoai']?>" >
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control" name="anh" type="file" value="<?php echo $result['anh']?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
            <input type="password" name="passs" class="form-control" placeholder="******">
        </div>
        <center>
        <button type="submit" name="submit" value="submit"class="inline-btn">update profile</button>
        </center>
        </form>
   </div>

</section>



<!-- custom js file link  -->
<script src="js/script.js"></script>

   
</body>
</html>