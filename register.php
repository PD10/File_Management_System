<!DOCTYPE html>
<html>
<head>
	<title>FILE MANAGEMENT SYSTEM</title>
	<link rel = "stylesheet" text = "text/css" href = "style.css">
	<style>
	body, html {
    height: 100%;
    margin: 0px;
	}

	.bg {
    	/* The image used */
    	background-image: url("filepic.jpg");

    	/* Full height */
    	height: 100%; 

    	/* Center and scale the image nicely */
    	background-position: center;
    	background-repeat: no-repeat;
    	background-size: cover;
    	position: relative;
	}
</style>
</head>

<body>
	<div class = "bg">
	<div class = "header">
		<h2>Register</h2>
	</div>

	<form action = "register.php" method = "post">
		<?php include('errors.php'); ?>
		<div class = "input-group">
			<label>Username:</label>
			<input type = "text" name = "username" value = "<?php echo $username; ?>" placeholder = "USERNAME">
		</div>
		<div class = "input-group">
			<label>Email:</label>
			<input type = "email" name = "email" value = "<?php echo $email; ?>" placeholder = "EMAIL">
		</div>
		<div class = "input-group">
			<label>Password:</label>
			<input type = "password" name = "password_1" placeholder = "PASSWORD">
		</div>
		<div class = "input-group">
			<label>Confirm Password:</label>
			<input type = "password" name = "password_2" placeholder = "CONFIRM PASSWORD">
		</div>
		<div class = "input-group">
			<button type = "submit" name = "register" class = "btn">Register</button>
		</div>

		<p>
			Already a member or Admin?<a href = "login.php">Sign In</a>
		</p> 
	</form>
	</div>
</body>
<html>