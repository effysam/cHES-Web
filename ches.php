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
header('Location: ches_login.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mobiDoc</title>
<!--<link rel="stylesheet" href="answerQs.css"/>-->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="jquery-1.9.1.min.js"></script>
<script src="jquery.loadJSON.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">-->
<script type="text/javascript">


$(document).ready(function(){
var qid;
var text;
var currId = 1;
var count = 0;
var category;
//function to load json data into DOM
$.getJSON("http://localhost/community/fetchQnAs.php?cmd=1",
    function(data){
	var data_result;
	 $.each(data.QnAs, function(i,question){
		if (currId == question.QUESTION_ID){
		count++;
		}
		
		//print question with multiple answers once
		if (count > 1){
		currId = question.QUESTION_ID;
		count--;
		
		$("#data").append('<ul class="well" style="margin-left:0px;">'+
		'<li class="ANSWER">'+ question.ANSWER +'</li>'+
		'<li class="SPEC_ID">'+ question.SPEC_NAME +'</li>'+
		'<li class="ANSWER_TIME">'+ question.ANSWER_TIME + '</li>'+
		'</ul>');
		}
		else{
		currId = question.QUESTION_ID;
		$("#data").append(
		'<ol id="QnAs">'+
		'<ul class="objs" style="margin-left:0px;">'+
		'<li class="QUESTION" id="question_' + i + '">' + question.QUESTION + '</li>'+
		'<li class="QUESTION_ID" id="question_id" value=' + question.QUESTION_ID + '></li>'+
		'<li class= "FIRSTNAME" id="firstname">' + question.FIRSTNAME + '</li>'+
		'<li class="LASTNAME" id="lastname">' + question.LASTNAME + '</li>'+
		'<li class="TIME" id="time">' + question.TIME + '</li>'+
		'</ul>'+
		'<ul class="ulToggle" style= "display: inline-block;margin-left:0px;" >'+
		'<li><a href="#"><span style= "display: inline-block; float: left;" class="Answer" id="Answer_' + i + '">Answer</span></a></li>'+
		'<form style="display:none;margin-left:0px;" class="Answer_' + i + '" id="form" method="POST" action="" value="form">'+
			'<textarea id="formtxtarea" style="margin-left: 0px; margin-right: 0px; min-width: 568px;max-width: 568px;min-height:110px;max-height:110px;"></textarea>'+
			'<div class="btn-group" data-toggle="buttons-radio" style="display:inline-block;">'+
				'<span class="btn btn-primary" id="genBtn" value="General">General</span>'+
				'<span class="btn btn-primary" id="nutBtn" value="Nutrition">Nutrition</span>'+
				'<span class="btn btn-primary" id="phBtn" value="Pharmaceutical">Pharmaceutical</span></div>'+
			'<span><input id="formButton" style= "float:right;" class="btn" type="submit" value="Submit Answer"></input></span>'+
			'<br></form>'+
		'<br></ul>'+
		'<ul class="well" style="margin-left:0px;">'+
		
		'<li class="ANSWER">'+ question.ANSWER +'</li>'+
		'<li class="SPEC_ID">'+ question.SPEC_NAME +'</li>'+
		'<li class="ANSWER_TIME">'+ question.ANSWER_TIME + '</li>'+
		'</ul>'+
		'</ol>');
		}	  
      });
    });




   $(document).on("click",'.Answer',function(){

	   //use regex to obtain digits in id of Answer link clicked on
	   var re = /\d{1,2}/;
	   var m = re.exec(event.target.id);
	   var forms = document.getElementsByTagName("form");
	   /*	iterate through the form elements to find a match in the form id and the Answer link id 
			to generate the specific form for that context */
	   for (var i = 0; i < forms.length; i++) {
		if (forms[i].className == 'Answer_'+m) {
			//hide/show answer form	
			$(forms[i]).toggle();
			qid = $(this).parent().parent().parent().siblings(".objs").children("li#question_id");	
				//button gruop for selecting category
					var category1 = category;
					$(document).on("click",'.btn-group',function(){
					category1 = ($('.active').text());
					});
					
			var submit = $(this).parent().parent().parent().children().children().children('input#formButton');	
			$(submit).click(function(){
			alert(category1);
			//get text from text area
			   text = $(this).parent().parent().parent().children().children('textarea#formtxtarea').val();
			   var qid1=qid.val();
			   
			//send data obtained over the server and insert into the database   
				$.ajax({
				   url: "http://localhost/community/answerQs.php?cmd=4&answer="+text+"&question_id="+qid1+"&category="+category1,
				   type: "POST",
				   contentType:'text',
				   data: {answer:text,question_id:qid1,category:category1},
				   dataType:'text'
					});
				alert("answer submitted");
				});	
			}
		}
	});
		
		
//load general answers
var $general; 
$general = $.get("http://localhost/community/answerQS.php?cmd=5", function(data) {
	$general=JSON.parse(data);
	$("#data1").loadJSON($general);
	});
//load nutrition answers
var $nutrition; 
$nutrition = $.get("http://localhost/community/answerQS.php?cmd=6", function(data) {
	$nutrition=JSON.parse(data);
	$("#data2").loadJSON($nutrition);
	});

//load pharmaceutical answers
var $pharmaceutical; 
$pharmaceutical = $.get("http://localhost/community/answerQS.php?cmd=7", function(data) {
	$pharmaceutical=JSON.parse(data);
	$("#data3").loadJSON($pharmaceutical);
	});

//load div with general answers contenct when clicked
document.querySelector("li#gen").addEventListener("click", function(){
    document.querySelector("div#data1").style.display = "block";
	$("div#data2").hide();
	$("div#data3").hide();
});
//load div with nutrition answers contenct when clicked
document.querySelector("li#nutr").addEventListener("click", function(){
    document.querySelector("div#data2").style.display = "block";
	$("div#data1").hide();
	$("div#data3").hide();
});
//load div with pharmaceutical answers contenct when clicked
document.querySelector("li#pharma").addEventListener("click", function(){
    document.querySelector("div#data3").style.display = "block";
	$("div#data1").hide();
	$("div#data2").hide();
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
			<li><a href="uploadContent.php">Upload content</a></li>
			</ul>
			<li><a id="logout"style=""href="logout.php">Logout</a></li>
            </nav>
        </div>
    </div>
	<div class="row-fluid">
		<h4 style="color: #090;" align="center">Welcome Dr. <?php echo $_SESSION['userid']?></h4>
		<div class="span12">
			<div style="margin:0px;" class="span6">
			<h5 style="color: #090;" align="center">View and Answer Questions</h5>
			<hr>
			<div  id="data">
			</div>
			</div>
			<div class="span6">
			<h5 style="color: #090;" align="center">Find existing answers to match with new questions</h5>
			<hr>
			<div style="border: 1px solid #e5e5e5; -webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;">	
				<ul class="nav nav-tabs">
					<li  id="gen"><a href="" data-toggle="tab">General</a></li>
					<li id="nutr" ><a href="" data-toggle="tab">Nutrition</a></li>
					<li id="pharma"><a href="" data-toggle="tab">Pharmaceutical</a></li>
					<form class="navbar-search pull-right" >
						<div class="input-append">
						<input style="height:17px;"type="text" class="input-medium search-query">
						<button style="height:25px; "type="submit" class="btn">Search</button>
						</div>
					</form>
				</ul>
			<div  style="display:none;" id="data1">
				<dl id="general">
					<div>					
						<div class="well">
						<dt class="QUESTION"></dt>
						<dt class="FIRSTNAME"></dt>
						<dt class="LASTNAME"></dt>
						<dt class="TIME"></dt>
						<br>
						<dt class="ANSWER"></dt>
						<dt class="SPEC_NAME"></dt>
						<dt class="ANSWER_TIME"></dt>
						</div>
					</div>
				</dl>			
			</div>
			<div  style="display:none;" id="data2">
				<dl id="nutrition">
					<div >
						<div>					
						<div class="well">
						<dt class="QUESTION"></dt>
						<dt class="FIRSTNAME"></dt>
						<dt class="LASTNAME"></dt>
						<dt class="TIME"></dt>
						<br>
						<dt class="ANSWER"></dt>
						<dt class="SPEC_NAME"></dt>
						<dt class="ANSWER_TIME"></dt>
						</div>
					</div>
					</div>
				</dl>			
			</div>
			<div  style="display:none;" id="data3">
				<dl id="pharmaceutical">
					<div>					
						<div class="well">
						<dt class="QUESTION"></dt>
						<dt class="FIRSTNAME"></dt>
						<dt class="LASTNAME"></dt>
						<dt class="TIME"></dt>
						<br>
						<dt class="ANSWER"></dt>
						<dt class="SPEC_NAME"></dt>
						<dt class="ANSWER_TIME"></dt>
						</div>
					</div>
				</dl>			
			</div>
			</div>
			</div>
			</div>
	</div>
		
	</div>	
</div>
<div class="footer"></div>
</body>
</html>