<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
$id = $_GET['id']; // Lấy giá trị id từ URL

$tim = "";
if(isset($_POST["tim"])) {
    $tim = $_POST["tim"];
}
$sql1 = "SELECT * FROM hocsinh join lop_hs on lop_hs.id_hs = hocsinh.id
join lophoc on lop_hs.id_lop = lophoc.id
where lophoc.id=$id and hocsinh.hoten LIKE '%$tim%' ";
$stmt = $conn->prepare($sql1);
$query = $stmt->execute();

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

        <h1>Danh sách lớp học</h1>
        <?php
    include "sidebar_ad.php";
    ?>

<section class="courses">
    <div class="tieude">
     <form action="" method="post" class="search-tutor">
      <input type="text" name="tim" placeholder="Tìm kiếm học viên" maxlength="100">
      <button type="submit" class="fas fa-search" name="search_tutor"></button>
     </form>
    </div>
<div class="container">
   <div class="bgtable">
   <table class="mytable" >
	  <thead>
	    <tr>
	      <th>Tên học viên</th>
	      <th>Điểm đầu vào</th>
          <th>Trạng thái</th>
          <th>Ngày bắt đầu</th>
          <th>Ngày kết thúc</th>
	    </tr>
	  </thead>
	  <tbody>
      <?php
                if($query){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        // Chuyển đổi định dạng ngày bắt đầu
                        $batdau = date('d-m-Y', strtotime($row["batdau"]));
                        // Chuyển đổi định dạng ngày kết thúc
                        $ketthuc = date('d-m-Y', strtotime($row["ketthuc"]));
                ?>
                    <tr>
                        <td><?php echo $row["hoten"]?></td>
                        <td><?php echo $row["diemdauvao"]?></td>
                        <td><?php echo $row["trangthai"]?></td>
                        <td><?php echo $batdau?></td>
                        <td><?php echo $ketthuc?></td>
                        
                    </tr>
                    <?php
                    }
                }
                ?>

  	  </tbody>
</table>
   </div>
</div>
</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>
  
</body>
</html>