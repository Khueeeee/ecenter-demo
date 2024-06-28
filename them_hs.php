<?php
    include "connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    $sql = "SELECT tenlop FROM lophoc";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($_POST["submit"])){
        if(isset($_POST["hoten"]) && isset($_FILES["anh"]) && isset($_POST["diemdauvao"])
        && isset($_POST["diachi"]) && isset($_POST["sdt"]) && isset($_POST["trangthai"]) 
        && isset($_POST["lophoc"])){

            $lophoc = $_POST["lophoc"];
            $sql1 = "select * from lophoc where tenlop ='$lophoc'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $id_lop = $row1['id'];

            $hoten = $_POST["hoten"];
            $diemdauvao = $_POST["diemdauvao"];
            $diachi = $_POST["diachi"];
            $sdt = $_POST["sdt"];
            $trangthai = $_POST["trangthai"];

            $anh = $_FILES["anh"]["name"];
            $anh_tmp = $_FILES["anh"]["tmp_name"];
            $folder = 'images/';
            move_uploaded_file($anh_tmp, $folder.$anh);

            $sql = "INSERT INTO hocsinh (anh, hoten, diemdauvao, diachi, sdt, trangthai) VALUES ('$folder$anh', '$hoten', '$diemdauvao','$diachi', '$sdt', '$trangthai')";
            $stmt = $conn->prepare($sql);
            $query = $stmt->execute();

            $id = $conn->lastInsertId();
            $sql1 = "INSERT INTO lop_hs (id_lop,id_hs) VALUES ('$id_lop', '$id')";
            $stmt = $conn->prepare($sql1);
            $query = $stmt->execute();
            if($query){
                header("location:index_hs.php");
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
   <title>Học sinh</title>

   <!-- font awesome cdn link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="header">
   
   <section class="flex">

        <h1>Thêm học sinh</h1>

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
            <label for="exampleFormControlInput1" class="form-label">Điểm đầu vào</label>
            <input type="text" name="diemdauvao" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên lớp học</label>
            <select class='form-control' name="lophoc" style=" font-size: 15px;" >
                    <?php foreach ($result as $class): ?>
                        <option><?php echo $class['tenlop']; ?></option>
                    <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="diachi" id="exampleFormControlTextarea1" rows="3">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Trạng thái</label>
            <input type="text" class="form-control" name="trangthai" id="exampleFormControlTextarea1" rows="3">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="sdt" id="exampleFormControlTextarea1" rows="3">
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