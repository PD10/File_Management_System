<?php include('server.php'); 

  //if user is not logged in, they cannot access this page
  if(empty($_SESSION['username'])){
    header('location: login.php');
  }
?>
<?php if(isset($_SESSION['success'])): ?>
  <?php
    //echo $_SESSION['success'];
    unset($_SESSION['success']);
  ?>
<?php endif ?>

<!DOCTYPE html>
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
</head>

<body>

<!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
      <a href="adminlandingpage.php" class="w3-bar-item w3-button w3-theme-l1">Home</a>
      <a href="adminuploadfile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Upload File</a>
      <a href="adminmyfiles.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Files</a>
      <a href="adminseeuserfiles.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">User Files</a>
      <a href="adminmakeusergroups.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Make Groups</a>
      <a href="adminseeadminmadegroups.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Admin Made Groups</a>
      <a href="adminseeusermadegroups.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">User Made Groups</a>
      <a href="adminsharefileadmingroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Share To Admin Groups</a>
      <a href="adminsharefileusergroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Share To User Groups</a>
      <a href="adminsharefileuser.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Share To User</a>
      <a href="adminsharedfilesadmingroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Shared Files: Admin Groups</a>
      <a href="adminsharedfilesusergroup.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Shared Files: User Groups</a>
      <a href="adminsharedfilesuser.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Shared Files: Users</a>
      <a href="login.php?logout = '1'" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Logout: <?php echo $_SESSION['username']; ?></a>
    </div>
  </div>

<!-- Sidebar -->
<!-- <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:43px;" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Menu</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="adminmakeusergroups.php">Make User Groups</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="adminseeuserfiles.php">User Files</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="adminmyfiles.php">My Files</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="adminuploadfile.php">Upload File</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="login.php?logout = '1'">Logout</a>
</nav> -->

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <!-- <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">MY FILES</h1>
      <p>MY FILES</p>
    </div>
  </div> -->

  <!-- <div class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">CREATE NEW FOLDER</h1>
      <p>CREATE NEW FOLDER</p>
    </div>
  </div> -->

  <!-- <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">UPLOAD FILE</h1>
      <p>UPLOAD FILE</p>
    </div>
  </div> -->

  <!-- Pagination -->
  <!-- <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a class="w3-button w3-black" href="#">1</a>
      <a class="w3-button w3-hover-black" href="#">2</a>
      <a class="w3-button w3-hover-black" href="#">3</a>
      <a class="w3-button w3-hover-black" href="#">4</a>
      <a class="w3-button w3-hover-black" href="#">5</a>
      <a class="w3-button w3-hover-black" href="#">&raquo;</a>
    </div>
  </div> -->

  <!-- <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Project by Pritish Das 15BCE0709</p>
    </div>
  </footer> -->

<!-- END MAIN -->
</div>

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