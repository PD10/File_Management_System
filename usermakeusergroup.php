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
<link rel = "stylesheet" text = "text/css" href = "style.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>
<script>
		function addRow(tableID) {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			if(rowCount < 5){							// limit the user from creating fields more than your limits
				var row = table.insertRow(rowCount);
				var colCount = table.rows[0].cells.length;
				for(var i=0; i<colCount; i++) {
					var newcell = row.insertCell(i);
					newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				}
			}else{
		 		alert("Maximum user group is 5.");
			   
			}
		}

		function deleteRow(tableID) {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) { 						// limit the user from removing all the fields
						alert("Cannot remove all the users.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}
			}
		}

		function alertusergroupcreated(){
			alert("User group created");
		}
	</script>
	<style>
  				html, body {
    				height: 100%;
  				}
  				#tableContainer-1 {
    				height: 100%;
    				width: 100%;
    				display: table;
  				}
  				#tableContainer-2 {
    				vertical-align: middle;
    				display: table-cell;
    				height: 100%;
  				}
  				#myTable {
    				margin: 0 auto;
    				background: #5F9EA0;
    				color: #fff;
    				border-radius: .4em;
    				overflow: hidden;
  				}
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
		<h2>Make User Groups</h2>
	</div>
	<form action = "usermakeusergroup.php" method = "post">
      	<div class = "input-group">
      		<input id = "userusergroupname" name = "userusergroupname" type = "text" placeholder = "WRITE THE NAME OF THE GROUP">
      	</div>
      	<div class = "input-group">
      		<input type="button" value="Add User" onClick="addRow('myTable')" /> 
			<input type="button" value="Remove User" onClick="deleteRow('myTable')"  /> 
			<p>(All actions apply only to entries with check marked check boxes only.)</p>
      	</div>
      	<div id="tableContainer-1">
      		<div id="tableContainer-2">
		      	<table id="myTable" class="form" border="1">
		                  <tbody>
		                    <tr>
		                      <p>
								<td><input type="checkbox" required="required" name="chk[]" checked="checked" /></td>
								 <td>
									<label for="BX_user" align = "center">User: </label>
									<select id="BX_user" name="BX_user[]" required="required">
										<option>...</option>
										<?php 
											$res = mysqli_query($db,"SELECT * FROM users WHERE USER_ID != 0");
											while($row = mysqli_fetch_array($res)){
										?>
											<option value = "<?php echo $row["USERNAME"]; ?>"><?php echo $row["USERNAME"]; ?></option>
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
        	<button type = "submit" name = "usermakeusergroups" class = "btn" onclick = "alertusergroupcreated()">Create Group</button>
      	</div>
    </form>

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