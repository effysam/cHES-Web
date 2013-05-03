<?php
// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['userid'])) {
header('Location: ches.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cHES</title>
<link rel="stylesheet" href="mobileTeacher.css"/>
</head>
<body>
<div class= "wrapper">
	<div class="div_header">
    	<div class="header_cont">
        	<nav class="head_nav">
        	<ul>
            <li><a href="#">About</a></li>
			<li><a href="#">Features</a></li>
			<li><a href="#">Contact and Support</a></li>
			</ul>
            </nav>
        </div>
    </div>
	<div class="main_content">
	<div class="sub_content">
    	<div class="container">
   		  <div class="auth-form">
            	<form method="POST" action="session_validity.php">
					<div class="auth-form-header">
                    	<h1>Sign in</h1>
                  </div>	
					<div class="auth-form-body">
						<p>Username<input autocapitalize="off" autofocus="autofocus" class="input-block" 
          				  id="login_field" name="userid" tabindex="1" type="text"></p>
						<p>Password<input autocomplete="disabled" class="input-block" id="password" name="password" tabindex="2" 
                        type="password"></p>
						<input type="submit" class="button" value="Log In">
					</div>
            </form>
       		 </div>
Building healthier communities through e-Health 	</div>
		
    </div>
    <div class="footer_push"></div>
	</div>
	
</div>
<div class="footer"></div>
</body>
</html>
