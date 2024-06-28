<?php
include "connect.php";
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['id_user'];
$sql1 = "SELECT * FROM taikhoan WHERE id = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(1, $user_id);
$stmt1->execute();
$result = $stmt1->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST["submit"])) {
    if (isset($_POST["username"], $_POST["passs"], $_POST["currentPasss"], $_POST["confirmPasss"])) {
        $username = $_POST["username"];
        $currentPasss = $_POST["currentPasss"];
        $newPasss = $_POST["passs"];
        $confirmPasss = $_POST["confirmPasss"];

        // Xác thực mật khẩu hiện tại
        if (!password_verify($currentPasss, $result['passs'])) {
            echo "Mật khẩu hiện tại không chính xác.";
            exit();
        }

        // Kiểm tra xác nhận mật khẩu mới
        if ($newPasss !== $confirmPasss) {
            echo "Mật khẩu mới và mật khẩu xác nhận không khớp.";
            exit();
        }

        $hashed_password = password_hash($newPasss, PASSWORD_DEFAULT);
        $sql = "UPDATE taikhoan SET username = ?, passs = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $hashed_password);
        $stmt->bindParam(3, $user_id);
        $query = $stmt->execute();

        if ($query) {
            header("location:accounts.php");
        } else {
            echo "Có lỗi xảy ra khi cập nhật thông tin.";
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
            <label for="currentPasss" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="currentPasss" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mật khẩu mới</label>
            <input type="password" name="passs" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="confirmPasss" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="confirmPasss" class="form-control" required>
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