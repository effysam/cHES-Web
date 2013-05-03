<?php
//handler for questions
if(!isset($_REQUEST['cmd'])){
	echo '{"result":0,"message":"cmd is not set"}';
	exit();
}
$cmd=$_REQUEST["cmd"];
include 'questions.php';
$q= new questions();
switch($cmd)
{	
	case 1: //ask a question
	/* set the cache limiter to 'private' */

	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();

	/* set the cache expire to 30 minutes */
	session_cache_expire(1);
	$cache_expire = session_cache_expire();

		$question = $_GET['question'];
		$nurse_id = $_GET['username'];
		
		$q->askQuestion($question,$nurse_id);
		break;
			
	default:
		echo '{"result":0,"message":"unknown command, the last one"}';
}
		
?>	