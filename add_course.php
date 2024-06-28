<?php
    include "connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    if(!empty($_POST["submit"])){
        if(isset($_POST["tenkhoahoc"]) && isset($_FILES["anh"])){
            $tenkhoahoc = $_POST["tenkhoahoc"];
            $noidung = $_POST["noidung"];

            // Xử lý file ảnh tải lên
            $anh = $_FILES["anh"]["name"];
            $anh_tmp = $_FILES["anh"]["tmp_name"];
            $folder = 'images/'; // Thư mục lưu ảnh
            move_uploaded_file($anh_tmp, $folder.$anh);
    
            // Cập nhật database
            $sql = "INSERT INTO khoahoc (tenkhoahoc, anh, noidung) 
            VALUES ('$tenkhoahoc', '$folder$anh', '$noidung')";
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();
            if($query){
                header("location:course.php");
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

        <h1>Thêm khóa học</h1>

        <?php
    include "sidebar_ad.php";
    ?>
<section class="addcourse">
<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên khóa học</label>
            <input type="text" name="tenkhoahoc" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control" name="anh" type="file" id="formFile">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Nội dung</label>
            <textarea class="form-control" name="noidung" id="exampleFormControlTextarea1" rows="3"></textarea>
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