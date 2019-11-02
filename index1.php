<?php include('server.php'); 

	//if user is not logged in, they cannot access this page
	if(empty($_SESSION['username'])){
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User registration system</title>
	<link rel = "stylesheet" text = "text/css" href = "style.css">
</head>

<body>
	<div class = "header">
		<h2>Home Page</h2>
	</div>

	<div class = "content">
		<?php if(isset($_SESSION['success'])): ?>
			<div class = "error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		 <?php if (isset($_SESSION["username"])): ?>
			<?php if($_SESSION["username"] == "admin"): ?>
				<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
				<p>
					Redirect to <a href = "adminlandingpage.php">ADMIN</a> panel
				</p>
			<?php else: ?>
				<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
				<p>Your User ID is <strong><?php echo $_SESSION['userid']; ?></strong></p>
				<p>
					Redirect to <a href = "userlandingpage.php">USER</a> panel
				</p>
			<?php endif ?>
			<p><a href = "login.php?logout = '1'" style = "color: red;">Logout</a></p>
		<?php endif ?>
	</div>
</body>
<html>