<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login-StatOverflow</title>
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
						SPOTIFY
					</span>

					<div>
						<input class="input100" type="email" name="mailid" id="mailid" placeholder="Username" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div>
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<input class="login100-form-btn" type="submit" name="submit_btn" id="submit"  value="Login" >
					</div>
				</form>
			</div>
		</div>
	</div>
	<center>
	<form action='reg.php'>
	<button class="login100-form-btn" id="regpage">								
	Sign Up
	</button>
	</form>
	</center>
					

</body>
</html>

<?php
$conn=mysqli_connect('localhost','root','','spotify');
if($conn)
{
    //echo "sucessful connection";
}
else
    echo "oh noooooo";
if(isset($_POST['submit_btn']))
{
    $mailid=$_POST['mailid'];
	$pass=$_POST['pass'];
	$pass=md5($pass);
    $query="SELECT* from user_details where (u_password ='$pass' && emailid='$mailid')";
    $result=mysqli_query($conn,$query);
    $row=mysqli_num_rows($result);
    if($row>0)
    {
		echo "<script>alert(Login Successful');</script>";
        echo "<script> window.open('http://127.0.0.1:8050/');</script>";  
    }
	else
	{
		echo "<script>alert('The details that you have entered donot match any account.');</script>";
	}
}
?>