<?php 
	include('server.php');
	
?>
<html>
<head>
	<title>FILE MANAGEMENT SYSTEM</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
	</style>
	<link rel = "stylesheet" text = "text/css" href = "style.css">
</head>

<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="userlandingpage.php" class="w3-bar-item w3-button w3-theme-l1">Home</a>
    <a href="useruploadfile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Upload File</a>
    <a href="usermyfiles.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Files</a>
    <a href="usermakeusergroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Make Groups</a>
    <a href="userseeusermadegroups.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Groups</a>
    <a href="usersharefileusergroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Share(Groups)</a>
    <a href="usersharefileusers.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Share(Users)</a>
    <a href="usersharedfilesuser.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Shared Users</a>
    <a href="usersharedfilesgroup" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Shared Groups</a>
    <a href="login.php?logout = '1'" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Logout: <?php echo $_SESSION['username']; ?></a>
    <!-- <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">User ID: <?php echo $_SESSION['userid']; ?></a> -->
  </div>
</div>

	<!-- Sidebar -->
	<!-- <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:43px;" id="mySidebar">
  		<a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    	<i class="fa fa-remove"></i>
  		</a>
  		<h4 class="w3-bar-item"><b>Menu</b></h4>
  		<a class="w3-bar-item w3-button w3-hover-black" href="usermyfiles.php">My Files</a>
  		<a class="w3-bar-item w3-button w3-hover-black" href="useruploadfile.php">Upload File</a>
  		<a class="w3-bar-item w3-button w3-hover-black" href="userlandingpage.php">Home</a>
  		<a class="w3-bar-item w3-button w3-hover-black" href="login.php?logout = '1'">Logout</a>
	</nav> -->

	<!-- Overlay effect when opening sidebar on small screens -->
	<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

	<div class = "header">
    <h2>SHOW/SEARCH MY FILES</h2>
</div>
<form>
  <div class = "input-group">
    <input id = "t1" name = "t1" type = "text" onKeyUp = "dynamicsearchajax();" autocomplete = "off" placeholder = "ENTER TEXT TO REVEAL TABLE">
  </div>
</form>
    
    
<div style = "margin:auto; min-width:145px; visibility:hidden " id = "d1">xyz</div>

<script type = "text/javascript">
  function dynamicsearchajax()
  {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET","server.php?nm4="+document.getElementById("t1").value,false);
    xmlhttp.send(null);
    document.getElementById("d1").innerHTML = xmlhttp.responseText;
    document.getElementById("d1").style.visibility = "visible";
  }
</script>

   <script>
	// Get the Sidebar
	var mySidebar = document.getElementById("mySidebar");

	// Get the DIV with overlay effect
	var overlayBg = document.getElementById("myOverlay");

	// Toggle between showing and hiding the sidebar, and add overlay effect
	function w3_open() {
    	if (mySidebar.style.display === 'block') {
        	mySidebar.style.display = 'none';
        	overlayBg.style.display = "none";
    	} else {
        	mySidebar.style.display = 'block';
        	overlayBg.style.display = "block";
    	}
	}

	// Close the sidebar with the close button
	function w3_close() {
    	mySidebar.style.display = "none";
    	overlayBg.style.display = "none";
	}
	</script>
</body>

</html>