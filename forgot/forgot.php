<?php 
session_start();
$error = array();

require "mail.php";

	if(!$con = mysqli_connect("localhost","root","1234","login")){

		die("could not connect");
	}

	$mode = "enter_email";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	//something is posted
	if(count($_POST) > 0){

		switch ($mode) {
			case 'enter_email':
				// code...
				$email = $_POST['email'];
				//validate email
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					$error[] = "Please enter a valid email";
				}elseif(!valid_email($email)){
					$error[] = "That email was not found";
				}else{

					$_SESSION['forgot']['email'] = $email;
					send_email($email);
					header("Location: forgot.php?mode=enter_code");
					die;
				}
				break;

			case 'enter_code':
				// code...
				$code = $_POST['code'];
				$result = is_code_correct($code);

				if($result == "the code is correct"){

					$_SESSION['forgot']['code'] = $code;
					header("Location: forgot.php?mode=enter_password");
					die;
				}else{
					$error[] = $result;
				}
				break;
			case 'enter_password':
				// code...
				$password = $_POST['password'];
				$password2 = $_POST['password2'];

				//error handlers
				if ($password === ''){
					$error[] = "Password cannot be empty";
				} elseif ($password !== $password2) {
					// code...
					$error[] = "password sjould be the same!";
				}  elseif (!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])) {
					header("Location: forgot.php");
					die;
				} else {
					save_password($password);
					if (isset($_SESSION['forgot'])){
						unset($_SESSION['forgot']);
					}
					header("location: ../login.php");
					die;
				}

				break;

			
			default:
				// code...
				break;
		}
	}

	/*function send_email($email){
		
		global $con;

		$expire = time() + (60 * 1);
		$code = rand(10000,99999);
		$email = addslashes($email);

		$query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
		mysqli_query($con,$query);

		//send email here
		send_mail($email,'Password reset',"Your code is " . $code);
	}*/
	/*function send_email($email){
		
		global $con;

		$expire = time() + (60 * 1);
		$email = addslashes($email);

		$check_query = "SELECT * FROM codes WHERE email= '$email'";
		$check_result = mysqli_query($con, $check_query);
		
		// Check if the email has been used to send a code before
		if (mysqli_num_rows($check_result) > 0) {
			$code = rand(100000,999999);
			$update_query = "UPDATE codes SET code ='$code', expire='$expire' WHERE email='$email'";
			$update_result = mysqli_query($con, $update_query);
			if (!$update_result) {
				echo "Error: " . mysqli_error($con) . "<br>";
			}
		}
		else {
			$code = rand(100000,999999);
			$insert_query = "INSERT INTO codes (email, code, expire) VALUES ('$email', '$code', '$expire')";
			$insert_result = mysqli_query($con, $insert_query);
			if (!$insert_result) {
				echo "Error: " . mysqli_error($con) . "<br>";
			}
		}
		
		//send email here
		send_mail($email,'Password reset',"Your code is " . $code);
	}*/

	function send_email($email){
	global $con;

	$subject = "Password reset verification OTP";
	$expire = time() + (60 * 5);
	$expire_date = date("Y-m-d H:i:s", $expire);
	$expire_time = date("H:i:s", $expire);
	$email = addslashes($email);

	$check_query = "SELECT * FROM codes WHERE email='$email'";
	$check_result = mysqli_query($con, $check_query);
	
	// Check if the email has been used to send a code before
	if (mysqli_num_rows($check_result) > 0) {
		$code = rand(100000,999999);
		$update_query = "UPDATE codes SET code='$code', expire='$expire_date', resetTimes=resetTimes+1 WHERE email='$email'";
		$update_result = mysqli_query($con, $update_query);
		if (!$update_result) {
			echo "Error: " . mysqli_error($con) . "<br>";
		}
	}
	else {
		$code = rand(100000,999999);
		$insert_query = "INSERT INTO codes (email, code, expire, resetTimes) VALUES ('$email', '$code', '$expire_date', 1)";
		$insert_result = mysqli_query($con, $insert_query);
		if (!$insert_result) {
			echo "Error: " . mysqli_error($con) . "<br>";
		}
	}
	// fetching the email username.
	$fetch_uid = "SELECT users_uid FROM users WHERE users_email='$email'";
	$fetch_uid_result = mysqli_query($con, $fetch_uid);

	if (mysqli_num_rows($fetch_uid_result) > 0){
		$row = mysqli_fetch_assoc($fetch_uid_result);
		$uid = $row['users_uid'];
	}
	
	//send email here
	send_mail($email, $subject, $code, $expire_time, $uid);
}


	function save_password($password){
		
		global $con;

		$password = password_hash($password, PASSWORD_DEFAULT);
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "update users set users_pwd = '$password' where users_email = '$email' limit 1";
		mysqli_query($con,$query);

	}
	
	function valid_email($email){
		global $con;

		$email = addslashes($email);

		$query = "select * from users where users_email = '$email' limit 1";		
		$result = mysqli_query($con,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				return true;
 			}
		}

		return false;

	}

	/*function is_code_correct($code){
		global $con;

		$code = addslashes($code);
		$expire = time();
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
		$result = mysqli_query($con,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				if($row['expire'] > $expire){

					return "the code is correct";
				}else{
					return "the code is expired";
				}
			}else{
				return "the code is incorrect";
			}
		}

		return "the code is incorrect";
	}*/
	function is_code_correct($code){
	global $con;

	$code = addslashes($code);
	$current_time = time();

	$email = addslashes($_SESSION['forgot']['email']);

	$query = "SELECT * FROM codes WHERE code = '$code' && email = '$email' ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($con, $query);
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$code_expire = strtotime($row['expire']);
			if ($current_time < $code_expire) {
				return "the code is correct";
			} else {
				return "the code is expired";
			}
		} else {
			return "the code is incorrect";
		}
	}

	return "the code is incorrect";
}


	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="0; url=http://example.com">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<title>Forgot</title>
</head>
<body>
<style type="text/css">
	*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    min-height: 100vh;
    background-color: #3f3f46;
    display: flex;
    font-family: sans-serif;

}
.centre{
    margin: auto;
    width: 500px;
    max-width: 90%;

}
.centre form{
    width: 100%;
    height: 100%;
    padding: 20px;
    background-color: white;
    border-radius: 4px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, .3);
}

.centre form h2{
    text-align: center;
    margin-bottom: 20px;
    color: #1d4ed8;
}
.centre form h4{
    text-align: center;
    margin-bottom: 24px;
    color: #1d4ed8;
}
.centre form span{
	text-align: centre;
	margin-bottom: 20px;
	color: #dc2626;
}
.centre form .textbox{
    width: 100%;
    height: 40px;
    background: white;
    border-radius: 4px;
    border: 1px solid silver;
    margin: 10px 0 18px 0;
    padding: 0 10px;
}
.centre form .btn{
    margin-left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 34px;
    border: none;
    outline: none;
    background: #27a327;
    cursor: pointer;
    font-size: 16px;
    text-transform: uppercase;
    color: white;
    border-radius: 4px;
    transition: .2s;

}
.button-align{
	display: flex;
	justify-content: space-between;
	
	
}
 .code-button1 a{
	background-color: #27a327;
	padding: 6px;
	color: white;
	text-decoration: none;
	border-radius: 5px;
	margin-top: 10px;
}
.button-code2{
	background-color:#27a327;
	padding: 6px 20px;
	color: #fff;
	border-radius: 5px;
	border: none;
	font-size: 16px;
}
</style>

		<?php 

			switch ($mode) {
				case 'enter_email':
					// code...
					?>
					<div class="centre">
						<form method="post" action="forgot.php?mode=enter_email"> 
							<h2>Forgot Password</h2>
							<h4>Enter your email below</h4>
							<span>
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>
							<input class="textbox" type="email" name="email" placeholder="Email"><br>
							<br style="clear: both;">
							<input type="submit" value="Next" class="btn">
							<br><br>
							<div><a href="../login.php">Login</a></div>
						</form>
					</div>
					<?php				
					break;

				case 'enter_code':
					// code...
					?>
					<div class="centre">
						<form method="post" action="forgot.php?mode=enter_code"> 
							<h2>Forgot Password</h2>
							<h4>Enter your the code sent to your email</h4>
							<span>
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input class="textbox" type="text" name="code" placeholder="enter_code"><br>
							<br style="clear: both;">
							<div class="button-align">
								<div class="code-button1">
									<a href="forgot.php">Start Over</a>
								</div>
								<input type="submit" value="Next" class="button-code2">
							</div>
							<br><br>
							<div><a href="../login.php">Login</a></div>
						</form>
					</div>
					<?php
					break;

				case 'enter_password':
					// code...
					?>
					<div class="centre">
						<form method="post" action="forgot.php?mode=enter_password"> 
							<h2>Forgot Password</h2>
							<h4>Enter your new password</h4>
							<span>
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input class="textbox" type="password" name="password" placeholder="Password"><br>
							<input class="textbox" type="password" name="password2" placeholder="Retype Password"><br>
							<br style="clear: both;">
							<div class="button-align">
								<div class="code-button1">
									<a href="forgot.php">Start Over</a>
								</div>
								<input type="submit" value="Next" style="padding: 6px 20px; color: #fff; border-radius: 5px; border: none; font-size: 16px;">
							</div>
							<br><br>
							<div><a href="../login.php">Login</a></div>
						</form>
					</div>
					<?php
					break;
				
				default:
					// code...
					break;
			}

		?>


</body>
</html>