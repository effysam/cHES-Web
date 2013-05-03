<?php
//handler for answers
if(!isset($_REQUEST['cmd'])){
	echo '{"result":0,"message":"unknown command"}';
	exit();
}
$cmd=$_REQUEST["cmd"];
include 'answers.php';
$b= new answers();
switch($cmd)
{
	case 1: //get all answers
		echo $b->getAllAnswers();
		break;
	
	case 2: //get json answers
		echo $b->fetchJSONanswers();
		break;
		
	case 3: //get answer
		echo $b->getAnswer($spec_id);
		break;
		
	case 4: //answer question
	
	/* set the cache limiter to 'private' */
	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();

	/* set the cache expire to 30 minutes */
	session_cache_expire(1);
	$cache_expire = session_cache_expire();

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
		header('Location: specialist.html');
	}
	$answer="";
		if(isset($_REQUEST["answer"])){
		$answer= $_REQUEST["answer"];
		}
	$question_id="";
		if(isset($_REQUEST["question_id"])){
		$question_id= $_REQUEST["question_id"];
		}
	$spec_id="";
		if (isset($_SESSION['userid'])) {
		$spec_id=$_SESSION['userid'];
		}
		$b->answerQuestion($answer,$spec_id,$question_id);
		break;
		
	case 5://get general answers
	echo $b->getGeneralAnswers();
	break;
	
	case 6://get nutrition answers
	echo $b->getNutritionalAnswers();
	break;
	
	case 7://get pharmaceutical answers
	echo $b->getPharmaceuticalAnswers();
	break;
	
	default:
		echo '{"result":0,"message":"unknown command"}';
}
	
	
?>