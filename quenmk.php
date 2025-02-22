<?php
   session_start();
   include 'connect.php';
   if(isset($_POST['submit'])){
            $name = $_POST['user'];
            $passnew = $_POST['passnew'];
            $passcf = $_POST['passcf'];
			$hashed_password = password_hash($passcf, PASSWORD_DEFAULT);
            if($passnew==$passcf){
            $sql1 = "update taikhoan set passs='$hashed_password' 
			where username='$name'";
			echo $name;
            $tmp = $conn->query($sql1);
            if($tmp){
               header('location:login.php');
            } else {
                echo "Có lỗi xảy ra khi cập nhật mật khẩu.";
            }
        } else {
            echo "Mật khẩu không khớp.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create new password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<script>
    function huy(){
        location.href="login.php";
    }
</script>
</head>
<body>
<form method="post">
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-49">
                    Create new password
					</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="user" placeholder="Type your username">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
						<span class="label-input100">New Password</span>
						<input class="input100" type="password" name="passnew" placeholder="Type your new password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
						<span class="label-input100">Confirm Password</span>
						<input class="input100" type="password" name="passcf" placeholder="Confirm your new password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="container-login100-form-btn" style="padding-top:20px">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" class="login100-form-btn" name="submit">
								Confirm
							</button>
						</div>
					</div>
                    <div class="container-login100-form-btn" style="padding-top:20px">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="button" class="login100-form-btn" onclick="huy()">
								Cancel
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</form>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
</form>
</body>
</html>
