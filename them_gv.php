<?php
    include "connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
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

            $anh = $_FILES["anh"]["name"];
            $anh_tmp = $_FILES["anh"]["tmp_name"];
            $folder = 'images/';
            move_uploaded_file($anh_tmp, $folder.$anh);

            $sql = "INSERT INTO giangvien (anh, hoten, tuoi, gioitinh, trinhdo, diachi, sodienthoai, gmail) VALUES ('$folder$anh', '$hoten', '$tuoi', '$gioitinh', '$trinhdo', '$diachi', '$sodienthoai', '$gmail')";
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();
            $teacherEmail = $_POST['gmail']; 
            $teacherId = $conn->lastInsertId();
            $defaultPassword = '12345';
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

           // Thêm tài khoản giáo viên vào bảng taikhoan
            $sqlAccount = "INSERT INTO taikhoan (username, passs, typee) VALUES (:username, :passs, :typee)";
            $stmtAccount = $conn->prepare($sqlAccount);
            $typee = 1; // Giả sử 1 là loại tài khoản cho giáo viên
            $stmtAccount->bindParam(':username', $teacherEmail);
            $stmtAccount->bindParam(':passs', $hashedPassword);
            $stmtAccount->bindParam(':typee', $typee);
            $stmtAccount->execute();
            $accountId = $conn->lastInsertId(); // Lấy ID của tài khoản mới được tạo
            echo $conn->lastInsertId();
            // Thêm thông tin liên kết vào bảng taikhoan_gv
            $sqlLink = "INSERT INTO taikhoan_gv (id_user, id_gv) VALUES (:id_user, :id_gv)";
            $stmtLink = $conn->prepare($sqlLink);
            $stmtLink->bindParam(':id_user', $accountId);
            $stmtLink->bindParam(':id_gv', $teacherId);
            $stmtLink->execute();
            if($query){
                header("location:index_gv.php");
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
   <title>Giảng viên</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

        <h1>Thêm giảng viên</h1>
        <?php
    include "sidebar_ad.php";
    ?>
<section class="addcourse">
<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Họ tên</label>
            <input type="text" name="hoten" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tuổi</label>
            <input type="text" name="tuoi" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Giới tính</label>
            <input type="text" name="gioitinh" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Trình độ</label>
            <input type="text" name="trinhdo" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="diachi" id="exampleFormControlTextarea1" rows="3">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Gmail</label>
            <input type="email" class="form-control" name="gmail" id="exampleFormControlTextarea1" rows="3">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="sodienthoai" id="exampleFormControlTextarea1" rows="3">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control" name="anh" type="file" id="formFile">
        </div>
        <div class="them">
            <button type="submit" name="submit" value="submit" class="btn">Thêm</button>
        </div>
        </form>
    </div>
</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>
  
</body>
</html>