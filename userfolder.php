<?php include('server.php'); ?>
<html>
<head>
	<link rel = "stylesheet" text = "text/css" href = "style.css">
</head>

<body>
	<div class = "header">
		<h2>Create Folder</h2>
	</div>
	<form action = "userfolder.php" method = "post">
		<div class = "input-group">
      		<label>New Folder Name:</label>
      		<input id = "folder" name = "userfoldername" type = "text" placeholder = "FOLDER NAME" required>
      	</div>
      	<div class = "input-group">
        	<button type = "submit" name = "usercreatefolder" class = "btn">Create</button>
      	</div>
      	<p>
			Return to <a href = "landingpage.php">home</a> page
		</p>
    </form>
</body>

</html>