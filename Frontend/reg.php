
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register-StatOverflow</title>
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
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/images.jpg');">
			<div class="wrap-login100">
				<form method="post">
					<span class="login100-form-logo">
					<img src = "img.png" width="50" height="50">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Register
					</span>

					<div>
						<input class="input100" type="name" name="fname"  id="fname" placeholder="Firstname" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div>
						<input class="input100" type="name" name="lname" id="lname" placeholder="Lastname" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div>
						<input class="input100" type="email" name="mailid" id="mailid" placeholder="Username" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div>
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
					<input class="login100-form-btn" type="submit" name="submit_btn"  id="submit" value="Register" >
					</div>
				</form>
			</div>
		</div>
	</div>
	

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

</body>
</html>

<?php
$conn=mysqli_connect('localhost','root','','spotify');
if($conn)
{
    // echo "sucessful connection";
}
else
    echo "oh noooooo";
 if(isset($_POST['submit_btn'])) 
 {
    //  echo"button clicked";
    $name=$_POST['fname'];
    $class=$_POST['lname'];
    $mailid=$_POST['mailid'];
    $pass=$_POST['pass'];
	$pass=md5($pass);

$query="INSERT INTO `user_details`( `firstname`, `lastname`, `emailid`, `u_password`)
 VALUES ('$name' ,'$class','$mailid','$pass')";
 $result=mysqli_query($conn,$query);
 if($result)
 {
     echo "<script>alert('Successfully Registered');</script>";
     echo "<script> window.open('index.php');</script>"; }
 } 
?>