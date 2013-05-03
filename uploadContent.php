<?php
/* set the cache limiter to 'private' */

session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* set the cache expire to 30 minutes */
session_cache_expire(30);
$cache_expire = session_cache_expire();

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
//header('Location: ches_login.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mobiDoc</title>
<!--<link rel="stylesheet" href="answerQs.css"/>-->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="jQuery-File-Upload-master/css/jquery.fileupload-ui.css">
<script src="jquery-1.9.1.min.js"></script>
<script src="jquery.loadJSON.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="prettify.css"></script>
<script src="bootsnipp.css"></script>
<script src="chosen.css"></script>
<script src="ajaxfileupload.js"></script>
<script type="text/javascript">

$(document).ready(function(){
var category;
var category1 = category;
					$(document).on("click",'.btn-group',function(){
					category1 = ($('.active').text());
					});
//form handler					
$(document).on("click",'#subEduDetails',function(showValues){
var str = $("form").serialize();
str=str+"&category="+category1;
alert(str);
			$.ajax({
			   url: "http://localhost/community/eduRepo.php?cmd=2&"+str,
			   type: "POST",
			   contentType:'text',
			   data: str,
			   dataType:'text'
			});
		});
});

</script>
</head>
<body>
<div class= "container">
	<div class="div_header">
	<br>
    	<div class="navbar">
        	<nav class="navbar-inner">
        	<ul class="nav">
			<li><a id ="logo" href="ches.php">cHES</a></li>
            <li><a href="#">About</a></li>
			<li><a href="#">Features</a></li>
			<li><a href="#">Contact and Support</a></li>
			<li><a href="#">Upload content</a></li>
			</ul>
			<li><a id="logout"style=""href="logout.php">Logout</a></li>
            </nav>
        </div>
    </div>

	<div class="row-fluid">

		<div style="color: #090;"class="span12 offset2">
			<div style="margin:0px;" class="span6">
			<h5 style="color: #00000;" align="center">Upload relevant decision support materials</h5>
			<hr>
			<div  id="data">
			<form id="eduDetails">
				<input class="input-xxlarge" id="inputTitle" type="text" name="title" placeholder="Title">
				<textarea rows="7" class="input-xxlarge" id="inputTitle" type="text" name="content" placeholder="Document Text"></textarea>
				<p>Category under which this material falls</p>
				<div  class="btn-group" data-toggle="buttons-radio" style="display:inline-block;">
					<span style="padding:4px 56px" class="btn btn-primary" id="genBtn" value="GENERAL" name="category">General</span>
					<span style="padding:4px 56px" class="btn btn-primary" id="nutBtn" value="NUTRITION" name="category">Nutrition</span>
					<span style="padding:4px 56px" class="btn btn-primary" id="phBtn" value="PHARMACEUTICAL" name="category">Pharmaceutical</span>
				</div>
				<div style="width:500px;"class="form-actions">
				  <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
					 <span style="padding:4px 42px; width:84px;" class="btn btn-success fileinput-button">
						<i class="icon-plus icon-white"></i>
						<span>Add files...</span>
					   <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
					</span>				  
					  <button style="padding:4px 57px;"type="reset" class="btn">Cancel</button>
					  <button id="subEduDetails"style="padding:4px 57px;"type="button" class="btn">Submit</button>
					  <p><tt id="results"></tt></p>
				 </form>
				</div>
			</form>
				
			</div>
			</div>
			
			
		</div>
	</div>
</div>
<div class="footer"></div>
</body>
</html>