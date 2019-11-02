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
		<h2>Login</h2>
	</div>
	<form action = "login.php" method = "post">
		<?php include('errors.php'); ?>
			<div class = "input-group">
				<label>Username:</label>
				<input type = "text" name = "username" placeholder = "USERNAME" required>
			</div>
			<div class = "input-group">
				<label>Password:</label>
				<input type = "password" name = "password" placeholder = "PASSWORD" required>
			</div>
			<div class = "input-group">
				<button type = "submit" name = "login" class = "btn">Login</button>
			</div>
			<p>
				Not yet a member?<a href = "register.php">Sign Up</a>
			</p> 
	</form>
	</div>
</body>
<html>