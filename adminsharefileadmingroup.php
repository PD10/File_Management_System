<?php include('server.php'); ?>
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
<link rel="stylesheet" text ="text/css" href = "style.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

<div class = "header">
	<h2>Share Files To Admin Groups</h2>
</div>
<form action = "adminsharefileadmingroup.php" method = "post">
    <div id="tableContainer-1">
      	<div id="tableContainer-2">
		    <table id="myTable" class="form" border="1">
		                  <tbody>
		                    <tr>
		                      <p>
								 <td>
									<label for="adminfilesharetoadmingroupfilename" align = "center">File Name: </label>
									<select id="adminfilesharetoadmingroupfilename" name="adminfilesharetoadmingroupfilename" required="required">
										<option>...</option>
										<?php 
											$res = mysqli_query($db,"SELECT * FROM adminfiles");
											while($row = mysqli_fetch_array($res)){
										?>
											<option value = "<?php echo $row["FILE_NAME"]; ?>"><?php echo $row["FILE_NAME"]; ?></option>
										<?php
											}
										?>
									</select>
								 </td>
								</p>
		                    </tr>
		                    </tbody>
		                </table>
		    </div>
        </div>
        <div id="tableContainer-1">
      	<div id="tableContainer-2">
		    <table id="myTable" class="form" border="1">
		                  <tbody>
		                    <tr>
		                      <p>
								 <td>
									<label for="adminfilesharetoadmingroupgroupname" align = "center">Admin Group Name: </label>
									<select id="adminfilesharetoadmingroupgroupname" name="adminfilesharetoadmingroupgroupname" required="required">
										<option>...</option>
										<?php 
											$res1 = mysqli_query($db,"SELECT * FROM admingroupinfo");
											while($row1 = mysqli_fetch_array($res1)){
										?>
											<option value = "<?php echo $row1["GROUP_NAME"]; ?>"><?php echo $row1["GROUP_NAME"]; ?></option>
										<?php
											}
										?>
									</select>
								 </td>
								</p>
		                    </tr>
		                    </tbody>
		                </table>
		    </div>
        </div>
		<div class = "input-group">
        	<button type = "submit" name = "adminsharefiletoadmingroup" class = "btn" onclick = "sharefile()">Share File</button>
      	</div>
    </form>
			<script type = "text/javascript">
			/*$(document).ready(function(){
				$('#search').bind('keyup',function(){
					var search = $(this).val();
					if(search == ''){
						//do nothing
						$('.input-group ul').html('');
					}
					else{
						//search
						$.get('server.php',{search:search},function(responseText){
								$('.input-group ul').html(responseText);
						});
					}
				});
			});
			$(document).ready(function(){
				$('#usergroup').bind('keyup',function(){
					var search = $(this).val();
					if(search == ''){
						//do nothing
						$('.input-group ul').html('');
					}
					else{
						//search
						$.get('server.php',{search:search},function(responseText){
								$('.input-group ul').html(responseText);
						});
					}
				});
			});*/
			function sharefile(){
				alert("File Shared To Admin Group");
			}
			</script>
	</form>
</body>
</html>