<?php
    include "connect.php";
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        // Nếu session không tồn tại hoặc bằng null, chuyển hướng về login.php
        header('Location: login.php');
        exit();
    }
    $tim = "";
    if(isset($_POST["tim"])) {
        $tim = $_POST["tim"];
    }
    $sql = "SELECT * FROM taikhoan WHERE username LIKE '%$tim%'";
    $stmt=$conn->prepare($sql);
    $query=$stmt->execute();

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

        <h1>Danh sách tài khoản</h1>

      <?php include "sidebar_ad.php"; ?>
<section class="courses">
    <div class="tieude">
     <form action="" method="post" class="search-tutor">
      <input type="text" name="tim" placeholder="Tìm kiếm tài khoản" maxlength="100">
      <button type="submit" class="fas fa-search" name="search_tutor"></button>
     </form>
    </div>
<div class="container">
    <div class="bgtable">
    <table class="mytable" >
	  <thead>
	    <tr>
	      <th>Tài khoản</th>
	      <th>Mật khẩu</th>
         <th>Phân quyền</th>
	      <th>Xóa </th>
	    </tr>
	  </thead>
	  <tbody>
      <?php
                if($query){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                     $phanQuyen = ($row["typee"] == 0) ? "Quản trị viên" : "Giảng viên";
                     $password = $row["passs"];
                     // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                ?>
                    <tr>
                        <td><?php echo $row["username"]?></td>
                        <td><?php echo $password ?></td>
                        <td><?php echo $phanQuyen?></td>
                        <td style="width:10%">
                           <div class="thaotac">
                              <a href="delete_acc.php?id=<?php echo $row['id']  ?>" class="suaxoa"><i class="fa-solid fa-trash"></i></a>
                           </div>
                             
                        </td>
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