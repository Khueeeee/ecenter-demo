<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$id = $_GET['id'];
$sql1 = "select * from taikhoan where id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$sql2 = "SELECT id_gv FROM taikhoan_gv WHERE id_user = '$id'";
$stmt = $conn->prepare($sql2);
$query = $stmt->execute();
$result1 = $stmt->fetch(PDO::FETCH_ASSOC);
$id_gv = $result1['id_gv'];


if(!empty($_POST['submit'])){
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $passs = $_POST["passs"];
        $typee = $_POST["typee"];

        $sql="update taikhoan set username = '$username', passs = '$passs',
        typee = '$typee' where id = '$id'";
        $stmt = $conn ->prepare($sql);
        $query = $stmt->execute();
        if($query){
            header("location:accounts.php?id=");
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
   <title>courses</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

        <h1>Thêm khóa học</h1>
        <?php
    include "sidebar_ad.php";
    ?>
<section class="addcourse">
<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên tài khoản</label>
            <input type="text" name="username" class="form-control" value="<?php echo $result['username']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mật khẩu</label>
            <input type="text" class="form-control" name="passs" value="<?php echo $result['passs']; ?>">
        </div>
        <div class="mb-3">
        <label for="exampleFormControlSelect1" class="form-label">Phân quyền</label>
        <select class="form-control" name="typee" id="exampleFormControlSelect1">
            <option value="0" <?php echo ($result['typee'] == '0') ? 'selected' : ''; ?>>Quản trị viên</option>
            <option value="1" <?php echo ($result['typee'] == '1') ? 'selected' : ''; ?>>Giảng viên</option>
        </select>
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