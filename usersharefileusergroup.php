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

<div class = "header">
	<h2>Share Files To User Groups</h2>
</div>
<form action = "usersharefileusergroup.php" method = "post">
    <div id="tableContainer-1">
      	<div id="tableContainer-2">
		    <table id="myTable" class="form" border="1">
		                  <tbody>
		                    <tr>
		                      <p>
								 <td>
									<label for="userfilesharetogroupfilename" align = "center">File Name: </label>
									<select id="userfilesharetogroupfilename" name="userfilesharetogroupfilename" required="required">
										<option>...</option>
										<?php 
											$res = mysqli_query($db,"SELECT * FROM userfiles");
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
									<label for="userfilesharetogroupgroupname" align = "center">Group Name: </label>
									<select id="userfilesharetogroupgroupname" name="userfilesharetogroupgroupname" required="required">
										<option>...</option>
										<?php 
											$res1 = mysqli_query($db,"SELECT * FROM usergroupinfo");
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
        	<button type = "submit" name = "usersharefiletogroup" class = "btn" onclick = "sharefile()">Share File</button>
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
				alert("File Shared To User Group");
			}
			</script>
	</form>
</body>
</html>