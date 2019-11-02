<?php 
	//log user in and redirect them to home page
	session_start();


	$username = "";
	$email = "";
	$errors = array();
	
	//connect to the database
	$db = mysqli_connect('localhost','root','','project');

	//if the register button is clicked then these events will take place
	if(isset($_POST['register'])){
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$email = mysqli_real_escape_string($db,$_POST['email']);
		$password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db,$_POST['password_2']);

		//ensure that form fields are filled properly
		if(empty($username)){
			array_push($errors, "Username is required");//add errors to errors array
		}
		if(empty($email)){
			array_push($errors, "Email is required");//add errors to errors array
		}
		if(empty($password_1)){
			array_push($errors, "Password is required");//add errors to errors array
		}

		if($password_1 != $password_2){
			array_push($errors,"The two passwords do not match");
		}

		//if there are no errors, save user to database
		if(count($errors) == 0){
			$password = md5($password_1);
			$sql = "INSERT INTO users(USERNAME, EMAIL, PASSWORD) VALUES('$username', '$email', '$password')";
			mysqli_query($db,$sql);
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: login.php');//redirect to home page
		}
	}

	//log user in from login page
	if(isset($_POST['login'])){
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$password = mysqli_real_escape_string($db,$_POST['password']);

		//ensure that form fields are filled properly
		if(empty($username)){
			array_push($errors, "Username is required");
		}
		if(empty($password)){
			array_push($errors, "Password is required");
		}

		if(count($errors) == 0){
			$password = md5($password); // encrypt password before comparing with that from database
			$query = "SELECT * FROM users WHERE USERNAME = '$username' AND PASSWORD = '$password'";
			$query1 = "SELECT USER_ID FROM users WHERE USERNAME = '$username' AND PASSWORD = '$password'";
			$result = mysqli_query($db,$query);
			$result1 = mysqli_query($db,$query1);
			$row = mysqli_fetch_array($result1);
			if(mysqli_num_rows($result) == 1){
				//log user in
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				$_SESSION['userid'] = $row[0];
				$userID = $_SESSION['userid'];
				if (isset($_SESSION["username"])){
					if($_SESSION["username"] == "admin"){
						header('location: adminlandingpage.php');//go to admin page
					}
					else{
						header('location: userlandingpage.php');//go to user page
					}
				}
				//header('location: index1.php'); //redirect to home page
			}
			else{
				array_push($errors, "wrong username/password combination");
			}
		}
	}

	//logout(logout button click hone baad wala event)
	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['userid']);
		header('location: register.php');
	}

	//user - create folder hone ke baad(User ka create folder button click hone ke baad)
	if(isset($_POST['usercreatefolder'])){
		mkdir($_POST['userfoldername']);
		$userfoldername = mysqli_real_escape_string($db,$_POST['userfoldername']);
		$sqluserinsertfoldername = "INSERT INTO userfolders(FOLDERNAME) VALUES('$userfoldername')";
			mysqli_query($db,$sqluserinsertfoldername);
		header('location: userfolder.php');
	}

	//user - after clicking the submit button the file gets stored in the userfolder
	if(isset($_POST['useruploadfile'])){
		//the folder to save in
		$userfoldertargetpath = "userfolder/";

		//building the stored file path
		$userfoldertargetpath = $userfoldertargetpath.basename($_FILES['userfilename']['name']);
			
		if(move_uploaded_file($_FILES['userfilename']['tmp_name'], $userfoldertargetpath)){
			echo "This file ".basename($_FILES['userfilename']['name']). " has been uploaded";
		}
		else{
			echo "There was an error uploading the file, please try again";
		}

		
		$userfilename = basename($_FILES['userfilename']['name']);
		$userfiledesc = mysqli_real_escape_string($db,$_POST['userfiledesc']);
		$sqluserupload = "INSERT INTO userfiles(FILE_NAME,USER_ID,FILE_DESC,FILE_PATH) VALUES('$userfilename','{$_SESSION['userid']}','$userfiledesc','$userfoldertargetpath')";
		mysqli_query($db,$sqluserupload);
		
	}
	//$userfolderoptions = "";

	//user - show my files button click hone baad wala event(click hone ke baad)
	//if(isset($_POST['$resultusershowmyfiles'])){
		
	//}
	//admin upload file button click hone ke baad file gets saved in adminfolder
	if(isset($_POST['adminuploadfile'])){
		//the folder to save in
		$adminfoldertargetpath = "adminfolder/";

		//building the stored file path
		$adminfoldertargetpath = $adminfoldertargetpath.basename($_FILES['adminfilename']['name']);
			
		if(move_uploaded_file($_FILES['adminfilename']['tmp_name'], $adminfoldertargetpath)){
			echo "This file ".basename($_FILES['adminfilename']['name']). " has been uploaded";
		}
		else{
			echo "There was an error uploading the file, please try again";
		}

		
		$adminfilename = basename($_FILES['adminfilename']['name']);
		$adminfiledesc = mysqli_real_escape_string($db,$_POST['adminfiledesc']);
		$sqladminupload = "INSERT INTO adminfiles(FILE_NAME,FILE_DESC,FILE_PATH) VALUES('$adminfilename','$adminfiledesc','$adminfoldertargetpath')";
		mysqli_query($db,$sqladminupload);
		
	}
		
	//admin create users group button click hone ke baad users ka group banane ke liye
	if(isset($_POST['adminmakeusergroups'])){
				$groupname = mysqli_real_escape_string($db,$_POST['adminusergroupname']);
				$sqlgroupnameupload = "INSERT INTO admingroupinfo(GROUP_NAME) VALUES('$groupname')";
				mysqli_query($db,$sqlgroupnameupload);
				$querygetgroupID = "SELECT MAX(GROUP_ID) FROM adminuserstogroup";
				$resultgetgroupID = mysqli_query($db,$querygetgroupID);
				$rowgetgroupID = mysqli_fetch_array($resultgetgroupID);
				$getmaxgroupID = $rowgetgroupID[0];
				$getmaxgroupID = $getmaxgroupID + 1;
				$users = $_POST['BX_user'];
				if($users){
					foreach($users as $c){
						$sqlusertogroup = "INSERT INTO adminuserstogroup(GROUP_ID,USER_NAME) VALUES(".$getmaxgroupID.",'".mysqli_real_escape_string($db,$c)."')";
						mysqli_query($db,$sqlusertogroup);
				}
			}
		}

	//user create users group button click hone ke baad users ka group banane ke liye
		if(isset($_POST['usermakeusergroups'])){
				$groupname = mysqli_real_escape_string($db,$_POST['userusergroupname']);
				$sqlgroupnameupload = "INSERT INTO usergroupinfo(GROUP_NAME) VALUES('$groupname')";
				mysqli_query($db,$sqlgroupnameupload);
				$querygetgroupID = "SELECT MAX(GROUP_ID) FROM useruserstogroup";
				$resultgetgroupID = mysqli_query($db,$querygetgroupID);
				$rowgetgroupID = mysqli_fetch_array($resultgetgroupID);
				$getmaxgroupID = $rowgetgroupID[0];
				$getmaxgroupID = $getmaxgroupID + 1;
				$users = $_POST['BX_user'];
				if($users){
					foreach($users as $c){
						$sqlusertogroup = "INSERT INTO useruserstogroup(GROUP_ID,USER_NAME) VALUES(".$getmaxgroupID.",'".mysqli_real_escape_string($db,$c)."')";
						mysqli_query($db,$sqlusertogroup);
				}
			}
		}

	//admin - see admin made user groups
		if(isset($_GET["nm"])){
		$nm = $_GET["nm"];
	$queryadminshowadmincreatedgroup = "SELECT * FROM admingroupinfo INNER JOIN adminuserstogroup USING (GROUP_ID, GROUP_ID) WHERE adminuserstogroup.GROUP_ID != 0 AND admingroupinfo.GROUP_NAME LIKE ('%$nm%') OR adminuserstogroup.USER_NAME LIKE ('%$nm%')";
	$resultadminshowadmincreatedgroup = mysqli_query($db,$queryadminshowadmincreatedgroup);
	if($resultadminshowadmincreatedgroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">GROUP NAME</th>
				<th align = "center">USERS(USERNAME)</th></tr>';

				while($rowadminshowadmincreatedgroup = mysqli_fetch_array($resultadminshowadmincreatedgroup)){
					echo '<tr>';
					echo '<td align = "center">'.
					$rowadminshowadmincreatedgroup['GROUP_NAME'].'</td>';
					echo '<td align = "center">'.
					$rowadminshowadmincreatedgroup['USER_NAME'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//admin - see user made user groups
	if(isset($_GET["nm3"])){
		$nm3 = $_GET["nm3"];
	$queryadminshowusercreatedgroup = "SELECT * FROM usergroupinfo INNER JOIN useruserstogroup USING (GROUP_ID, GROUP_ID) WHERE useruserstogroup.GROUP_ID != 0 AND usergroupinfo.GROUP_NAME LIKE ('%$nm3%') OR useruserstogroup.USER_NAME LIKE ('%$nm3%')";
	$resultadminshowusercreatedgroup = mysqli_query($db,$queryadminshowusercreatedgroup);
	if($resultadminshowusercreatedgroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">GROUP NAME</th>
				<th align = "center">USERS(USERNAME)</th></tr>';

				while($rowadminshowusercreatedgroup = mysqli_fetch_array($resultadminshowusercreatedgroup)){
					echo '<tr>';
					echo '<td align = "center">'.
					$rowadminshowusercreatedgroup['GROUP_NAME'].'</td>';
					echo '<td align = "center">'.
					$rowadminshowusercreatedgroup['USER_NAME'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//admin - see admin made files
	if(isset($_GET["nm1"])){
    $nm1 = $_GET["nm1"];
	  $queryadminshowmyfiles = "SELECT * FROM adminfiles WHERE FILE_NAME LIKE ('%$nm1%')";
	  $resultadminshowmyfiles = mysqli_query($db,$queryadminshowmyfiles);
	   if($resultadminshowmyfiles){
  		echo '<style>
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
              background: #000000;
              color: #fff;
              border-radius: .4em;
              overflow: hidden;
    				}
            th{
              color: #dd5;
            }
  			   </style>
  			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

  			<tr><th align = "center">FILE NAME</th>
  			<th align = "center">FILE DESCRIPTION</th></tr>';

    		while($rowadminshowmyfiles = mysqli_fetch_array($resultadminshowmyfiles)){
    			echo '<tr>';
    			echo '<td align = "center">';?><a href = "<?php echo $rowadminshowmyfiles['FILE_PATH']; ?>"><?php echo $rowadminshowmyfiles['FILE_NAME']; ?></a>
    			<?php echo '</td>';
    			echo '<td align = "center">'.
    			$rowadminshowmyfiles['FILE_DESC'].'</td>';

    			echo '</tr>';
    		}

    		echo '</table>';
    	}
    	else{
    		echo "Couldn't issue database query";
    	}
    }

    //admin - see all the user made files
    if(isset($_GET["nm2"])){
    $nm2 = $_GET["nm2"];
	$queryadminshowuserfiles = "SELECT * FROM userfiles WHERE FILE_NAME LIKE ('%$nm2%')";
	$resultadminshowuserfiles = mysqli_query($db,$queryadminshowuserfiles);
	if($resultadminshowuserfiles){
		echo '<style>
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
            background: #000000;
            color: #fff;
            border-radius: .4em;
            overflow: hidden;
  				}
          th{
            color: #dd5;
          }
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			<tr><th align = "center">FILE NAME</th>
			<th align = "center">FILE DESCRIPTION</th></tr>';

		while($rowadminshowuserfiles = mysqli_fetch_array($resultadminshowuserfiles)){
			echo '<tr>';
			echo '<td align = "center">';?><a href = "<?php echo $rowadminshowuserfiles['FILE_PATH']; ?>"><?php echo $rowadminshowuserfiles['FILE_NAME']; ?></a>
			<?php echo '</td>';
			echo '<td align = "center">'.
			$rowadminshowuserfiles['FILE_DESC'].'</td>';

			echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//user - see his/her files
	if(isset($_GET["nm4"])){
		$nm4 = $_GET["nm4"];
		$queryusershowmyfiles = "SELECT * FROM userfiles WHERE USER_ID = '{$_SESSION['userid']}' AND FILE_NAME LIKE ('%$nm4%')";
	$resultusershowmyfiles = mysqli_query($db,$queryusershowmyfiles);
	if($resultusershowmyfiles){
		echo '<style>
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
    				background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
  				th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			<tr><th>FILE NAME</th>
			<th>FILE DESCRIPTION</th></tr>';

		while($rowusershowmyfiles = mysqli_fetch_array($resultusershowmyfiles)){
			echo '<tr>';
			echo '<td align = "center">';?><a href = "<?php echo $rowusershowmyfiles['FILE_PATH']; ?>"><?php echo $rowusershowmyfiles['FILE_NAME']; ?></a>
			<?php echo '</td>';
			echo '<td align = "center">'.
			$rowusershowmyfiles['FILE_DESC'].'</td>';

			echo '</tr>';
		}

		echo '</table>';
		echo '</div>';
		echo '</div>';
	}
	else{
		echo "Couldn't issue database query";
	}
	}

	//user - see user made user groups
	if(isset($_GET["nm5"])){
		$nm5 = $_GET["nm5"];
	$queryusershowusercreatedgroup = "SELECT * FROM usergroupinfo INNER JOIN useruserstogroup USING (GROUP_ID, GROUP_ID) WHERE useruserstogroup.GROUP_ID != 0 AND usergroupinfo.GROUP_NAME LIKE ('%$nm5%') OR useruserstogroup.USER_NAME LIKE ('%$nm5%')";
	$resultusershowusercreatedgroup = mysqli_query($db,$queryusershowusercreatedgroup);
	if($resultusershowusercreatedgroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">GROUP NAME</th>
				<th align = "center">USERS(USERNAME)</th></tr>';

				while($rowusershowusercreatedgroup = mysqli_fetch_array($resultusershowusercreatedgroup)){
					echo '<tr>';
					echo '<td align = "center">'.
					$rowusershowusercreatedgroup['GROUP_NAME'].'</td>';
					echo '<td align = "center">'.
					$rowusershowusercreatedgroup['USER_NAME'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//user - see user shared files to group
	if(isset($_GET["nm6"])){
		$nm6 = $_GET["nm6"];
	$queryusersharedfilesgroup = "SELECT * FROM usersharefiletogroup WHERE FILE_NAME LIKE ('%$nm6%') OR FILE_DESC LIKE ('%$nm6%') OR FROM_USER LIKE ('%$nm6%') OR TO_USERGROUP LIKE ('%$nm6%')";
	$resultusersharedfilesgroup = mysqli_query($db,$queryusersharedfilesgroup);
	if($resultusersharedfilesgroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">FILE NAME</th>
				<th align = "center">FILE DESCRIPTION</th>
				<th align = "center">FROM USER</th>
				<th align = "center">TO GROUP</th></tr>';

				while($rowusersharedfilesgroup = mysqli_fetch_array($resultusersharedfilesgroup)){
					echo '<tr>';
					echo '<td align = "center">';?><a href = "<?php echo $rowusersharedfilesgroup['FILE_PATH']; ?>"><?php echo $rowusersharedfilesgroup['FILE_NAME']; ?></a>
					<?php echo '</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesgroup['FILE_DESC'].'</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesgroup['FROM_USER'].'</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesgroup['TO_USERGROUP'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//user - see user shared files to user
	if(isset($_GET["nm7"])){
		$nm7 = $_GET["nm7"];
	$queryusersharedfilesuser = "SELECT * FROM usersharefiletouser WHERE FILE_NAME LIKE ('%$nm7%') OR FILE_DESC LIKE ('%$nm7%') OR FROM_USER LIKE ('%$nm7%') OR TO_USER LIKE ('%$nm7%')";
	$resultusersharedfilesuser = mysqli_query($db,$queryusersharedfilesuser);
	if($resultusersharedfilesuser){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">FILE NAME</th>
				<th align = "center">FILE DESCRIPTION</th>
				<th align = "center">FROM USER</th>
				<th align = "center">TO USER</th></tr>';

				while($rowusersharedfilesuser = mysqli_fetch_array($resultusersharedfilesuser)){
					echo '<tr>';
					echo '<td align = "center">';?><a href = "<?php echo $rowusersharedfilesuser['FILE_PATH']; ?>"><?php echo $rowusersharedfilesuser['FILE_NAME']; ?></a>
					<?php echo '</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesuser['FILE_DESC'].'</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesuser['FROM_USER'].'</td>';
					echo '<td align = "center">'.
					$rowusersharedfilesuser['TO_USER'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//admin - see admin shared files to admin group
	if(isset($_GET["nm8"])){
		$nm8 = $_GET["nm8"];
	$queryadminsharedfilesadmingroup = "SELECT * FROM adminsharefiletoadmingroup WHERE FILE_NAME LIKE ('%$nm8%') OR FILE_DESC LIKE ('%$nm8%') OR FROM_ADMIN LIKE ('%$nm8%') OR TO_ADMINGROUP LIKE ('%$nm8%')";
	$resultadminsharedfilesadmingroup = mysqli_query($db,$queryadminsharedfilesadmingroup);
	if($resultadminsharedfilesadmingroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">FILE NAME</th>
				<th align = "center">FILE DESCRIPTION</th>
				<th align = "center">FROM ADMIN</th>
				<th align = "center">TO ADMIN GROUP</th></tr>';

				while($rowadminsharedfilesadmingroup = mysqli_fetch_array($resultadminsharedfilesadmingroup)){
					echo '<tr>';
					echo '<td align = "center">';?><a href = "<?php echo $rowadminsharedfilesadmingroup['FILE_PATH']; ?>"><?php echo $rowadminsharedfilesadmingroup['FILE_NAME']; ?></a>
					<?php echo '</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesadmingroup['FILE_DESC'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesadmingroup['FROM_ADMIN'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesadmingroup['TO_ADMINGROUP'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//admin - see admin shared files to user group
	if(isset($_GET["nm9"])){
		$nm9 = $_GET["nm9"];
	$queryadminsharedfilesusergroup = "SELECT * FROM adminsharefiletousergroup WHERE FILE_NAME LIKE ('%$nm9%') OR FILE_DESC LIKE ('%$nm9%') OR FROM_ADMIN LIKE ('%$nm9%') OR TO_USERGROUP LIKE ('%$nm9%')";
	$resultadminsharedfilesusergroup = mysqli_query($db,$queryadminsharedfilesusergroup);
	if($resultadminsharedfilesusergroup){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">FILE NAME</th>
				<th align = "center">FILE DESCRIPTION</th>
				<th align = "center">FROM ADMIN</th>
				<th align = "center">TO USER GROUP</th></tr>';

				while($rowadminsharedfilesusergroup = mysqli_fetch_array($resultadminsharedfilesusergroup)){
					echo '<tr>';
					echo '<td align = "center">';?><a href = "<?php echo $rowadminsharedfilesusergroup['FILE_PATH']; ?>"><?php echo $rowadminsharedfilesusergroup['FILE_NAME']; ?></a>
					<?php echo '</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesusergroup['FILE_DESC'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesusergroup['FROM_ADMIN'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesusergroup['TO_USERGROUP'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}

	//admin - see admin shared files to user
	if(isset($_GET["nm10"])){
		$nm10 = $_GET["nm10"];
	$queryadminsharedfilesuser = "SELECT * FROM adminsharefiletouser WHERE FILE_NAME LIKE ('%$nm10%') OR FILE_DESC LIKE ('%$nm10%') OR FROM_ADMIN LIKE ('%$nm10%') OR TO_USER LIKE ('%$nm10%')";
	$resultadminsharedfilesuser = mysqli_query($db,$queryadminsharedfilesuser);
	if($resultadminsharedfilesuser){
		echo'<style>
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
            		background: #000000;
            		color: #fff;
            		border-radius: .4em;
            		overflow: hidden;
  				}
          		th{
            		color: #dd5;
          		}
			   </style>
			   <div id="tableContainer-1"><div id="tableContainer-2"><table id="myTable" border>

			   <tr><th align = "center">FILE NAME</th>
				<th align = "center">FILE DESCRIPTION</th>
				<th align = "center">FROM ADMIN</th>
				<th align = "center">TO USER</th></tr>';

				while($rowadminsharedfilesuser = mysqli_fetch_array($resultadminsharedfilesuser)){
					echo '<tr>';
					echo '<td align = "center">';?><a href = "<?php echo $rowadminsharedfilesuser['FILE_PATH']; ?>"><?php echo $rowadminsharedfilesuser['FILE_NAME']; ?></a>
					<?php echo '</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesuser['FILE_DESC'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesuser['FROM_ADMIN'].'</td>';
					echo '<td align = "center">'.
					$rowadminsharedfilesuser['TO_USER'].'</td>';

					echo '</tr>';
		}

		echo '</table>';
	}
	else{
		echo "Couldn't issue database query";
	}
}
	
	//user - will show the names of the files to be shared by user
	/*if(isset($_GET['search']) && !empty($_GET['search'])){
		$search = $_GET['search'];
		$terms = explode(' ',$search);
		$i = 0;
		$query = '';
		foreach ($terms as $term){
			$i++;
			if($i == 1){
				$query .= "FILE_NAME LIKE '%$term%' ";
			}
			else{
				$query .= "AND FILE_NAME LIKE '%$term%' ";
			}
		}
		$q = mysqli_query($db,"SELECT * FROM userfiles WHERE $query");
		if(mysqli_num_rows($q) > 0){
			while($row = mysqli_fetch_assoc($q)){
				echo "<li>".$row['FILE_NAME']."</li>";
			}
		}
		else{
			echo "<li>No Result</li>";
		}
	}

	//user - will show the names of the (user)groups to be shared by the user
	if(isset($_GET['usergroup']) && !empty($_GET['usergroup'])){
		$search = $_GET['usergroup'];
		$terms = explode(' ',$search);
		$i = 0;
		$query = '';
		foreach ($terms as $term){
			$i++;
			if($i == 1){
				$query .= "GROUP_NAME LIKE '%$term%' ";
			}
			else{
				$query .= "AND GROUP_NAME LIKE '%$term%' ";
			}
		}
		$q = mysqli_query($db,"SELECT * FROM usergroupinfo WHERE $query");
		if(mysqli_num_rows($q) > 0){
			while($row = mysqli_fetch_assoc($q)){
				echo "<li>".$row['GROUP_NAME']."</li>";
			}
		}
		else{
			echo "<li>No Result</li>";
		}
	}*/

	//user - share file to group
	if(isset($_POST['usersharefiletogroup'])){
		$userfilesharetogroupfilename = mysqli_real_escape_string($db,$_POST['userfilesharetogroupfilename']);
		$userfilesharetogroupgroupname = mysqli_real_escape_string($db,$_POST['userfilesharetogroupgroupname']);
		$query = "SELECT * FROM userfiles WHERE FILE_NAME = '$userfilesharetogroupfilename'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$filedesc = $row['FILE_DESC'];
		$filepath = $row['FILE_PATH'];
		$sql = "INSERT INTO usersharefiletogroup(FILE_NAME, FILE_DESC, FILE_PATH, FROM_USER, TO_USERGROUP) VALUES('$userfilesharetogroupfilename', '$filedesc', '$filepath','{$_SESSION['username']}','$userfilesharetogroupgroupname')";
		//"INSERT INTO useruserstogroup(GROUP_ID,USER_NAME) VALUES(".$getmaxgroupID.",'".mysqli_real_escape_string($db,$c)."')"
			mysqli_query($db,$sql);
	}

	//user - share file to user 
	if(isset($_POST['usersharefiletouser'])){
		$userfilesharetouserfilename = mysqli_real_escape_string($db,$_POST['userfilesharetouserfilename']);
		$userfilesharetouserusername = mysqli_real_escape_string($db,$_POST['userfilesharetouserusername']);
		$query = "SELECT * FROM userfiles WHERE FILE_NAME = '$userfilesharetouserfilename'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$filedesc = $row['FILE_DESC'];
		$filepath = $row['FILE_PATH'];
		$sql = "INSERT INTO usersharefiletouser(FILE_NAME, FILE_DESC, FILE_PATH, FROM_USER, TO_USER) VALUES('$userfilesharetouserfilename', '$filedesc', '$filepath','{$_SESSION['username']}','$userfilesharetouserusername')";
		mysqli_query($db,$sql);
	}

	//admin - share file to admin group
	if(isset($_POST['adminsharefiletoadmingroup'])){
		$adminfilesharetoadmingroupfilename = mysqli_real_escape_string($db,$_POST['adminfilesharetoadmingroupfilename']);
		$adminfilesharetoadmingroupgroupname = mysqli_real_escape_string($db,$_POST['adminfilesharetoadmingroupgroupname']);
		$query = "SELECT * FROM adminfiles WHERE FILE_NAME = '$adminfilesharetoadmingroupfilename'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$filedesc = $row['FILE_DESC'];
		$filepath = $row['FILE_PATH'];
		$sql = "INSERT INTO adminsharefiletoadmingroup(FILE_NAME, FILE_DESC, FILE_PATH, FROM_ADMIN, TO_ADMINGROUP) VALUES('$adminfilesharetoadmingroupfilename', '$filedesc', '$filepath','{$_SESSION['username']}','$adminfilesharetoadmingroupgroupname')";
		mysqli_query($db,$sql);
	}

	//admin - share file to user group
	if(isset($_POST['adminsharefiletousergroup'])){
		$adminfilesharetousergroupfilename = mysqli_real_escape_string($db,$_POST['adminfilesharetousergroupfilename']);
		$adminfilesharetousergroupgroupname = mysqli_real_escape_string($db,$_POST['adminfilesharetousergroupgroupname']);
		$query = "SELECT * FROM adminfiles WHERE FILE_NAME = '$adminfilesharetousergroupfilename'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$filedesc = $row['FILE_DESC'];
		$filepath = $row['FILE_PATH'];
		$sql = "INSERT INTO adminsharefiletousergroup(FILE_NAME, FILE_DESC, FILE_PATH, FROM_ADMIN, TO_USERGROUP) VALUES('$adminfilesharetousergroupfilename', '$filedesc', '$filepath','{$_SESSION['username']}','$adminfilesharetousergroupgroupname')";
		mysqli_query($db,$sql);
	}

	//admin - share file to user
	if(isset($_POST['adminsharefiletouser'])){
		$adminfilesharetouserfilename = mysqli_real_escape_string($db,$_POST['adminfilesharetouserfilename']);
		$adminfilesharetouserusername = mysqli_real_escape_string($db,$_POST['adminfilesharetouserusername']);
		$query = "SELECT * FROM adminfiles WHERE FILE_NAME = '$adminfilesharetouserfilename'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$filedesc = $row['FILE_DESC'];
		$filepath = $row['FILE_PATH'];
		$sql = "INSERT INTO adminsharefiletouser(FILE_NAME, FILE_DESC, FILE_PATH, FROM_ADMIN, TO_USER) VALUES('$adminfilesharetouserfilename', '$filedesc', '$filepath','{$_SESSION['username']}','$adminfilesharetouserusername')";
		mysqli_query($db,$sql);
	}
?>