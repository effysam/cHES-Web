<?php

// Inialize session
session_start();

		$link=mysql_connect("localhost","root","optimus1");
		if(!$link){
			echo "<span style='color:red'>error connecting to db</span>";
			exit();	
		}
		
		if(!mysql_select_db("communityhealth",$link)){
			echo "<span style='color:red'>error selecting db</span>";
			exit();	
		}


// Retrieve username and password from database according to user's input
	//$pword= md5($pword);
		$login = mysql_query("SELECT SPEC_NAME from specialist WHERE (SPEC_USERNAME = '" . $_POST['userid'] . "')
						and (SPEC_PASSWORD = '" . md5($_POST['password']) . "')");

	// Check username and password match
		if (mysql_num_rows($login) > 0) {
		while ($row = mysql_fetch_array($login)){
			//echo $row[0];
	// Set username session variable
		$_SESSION['userid'] = $row[0];
	// Jump to secured page
		header('Location: ches.php');
	}
		}	
		else {
	// Jump to login page
		header('Location: ches_login.php');
		}		
?>	
	