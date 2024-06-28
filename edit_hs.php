<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$id = $_GET["id"];
$sql1 = "SELECT * FROM hocsinh WHERE id = '$id'";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT tenlop FROM lophoc ";
$stmt = $conn->prepare($sql);
$query = $stmt->execute();
$result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql1 = "SELECT tenlop from lophoc join lop_hs on lop_hs.id_lop = lophoc.id 
join hocsinh on lop_hs.id_hs = hocsinh.id 
      WHERE hocsinh.id=:id_hs";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute(['id_hs' => $result['id']]); 
$gtri = $stmt1->fetch(PDO::FETCH_ASSOC);
if ($stmt1->rowCount() != 0) {
$lophientai = $gtri['tenlop'];
}
else{
    $lophientai = '';
}

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

        if(isset($_FILES['anh']) && $_FILES['anh']['error'] == 0){
            $anh = $_FILES['anh']['name'];
            $anh_tmp = $_FILES['anh']['tmp_name'];
            $folder = ''; 
            move_uploaded_file($anh_tmp, $folder.$anh);
        } else {
            $anh = $result['anh'];
        }
        if ($lophientai==''){
            $sql2 = "insert into lop_hs(id_hs,id_lop) values( '$id', '$id_lop')";
            $stmt = $conn->prepare($sql2);
            $query = $stmt->execute();
        }else{
            $sql1 = "UPDATE lop_hs SET id_lop = '$id_lop' where id_hs='$id'";
            $stmt = $conn->prepare($sql1);
            $query = $stmt->execute();
        }
        
        $sql = "UPDATE hocsinh SET hoten = '$hoten', anh = '$folder$anh', diemdauvao = '$diemdauvao' , diachi = '$diachi', sdt = '$sdt', trangthai = '$trangthai' where id = '$id'";
        $stmt = $conn->prepare($sql);
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

        <h1>Sửa thông tin học sinh</h1>

        <?php
    include "sidebar_ad.php";
    ?>
<section class="addcourse">
<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Họ tên học sinh</label>
            <input type="text" name="hoten" class="form-control" value="<?php echo $result['hoten']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Điểm đầu vào</label>
            <input type="text" name="diemdauvao" class="form-control" value="<?php echo $result['diemdauvao']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên lớp học</label>
            <select class='form-control' name="lophoc" style="font-size: 15px;">
                <?php foreach ($result1 as $gtri): ?>
                    <option <?php if ($gtri['tenlop'] == $lophientai) echo 'selected'; ?>><?php echo $gtri['tenlop']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Địa chỉ</label>
            <input type="text" name="diachi" class="form-control" value="<?php echo $result['diachi']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
            <input type="text" name="sdt" class="form-control" value="<?php echo $result['sdt']?>" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Trạng thái</label>
            <input type="text" name="trangthai" class="form-control" value="<?php echo $result['trangthai']?>" >
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control" name="anh" type="file" value="<?php echo $result['anh']?>">
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