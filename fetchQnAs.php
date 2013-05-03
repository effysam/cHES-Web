<?php
/* hander for questionsWithAnswers
*
*/
if(!isset($_REQUEST['cmd'])){
	echo '{"result":0,"message":"cmd is not set"}';
	exit();
}
$cmd=$_REQUEST["cmd"];
include 'questionsWithAnswers.php';
$q= new questionsWithAnswers();
switch($cmd)
{
	case 1://fetch all questions and answers to them
		echo $q->fetchJSONquestionsWithAnswers();
		break;
		
	case 2: //fetch all QnAs with answers for nurse
	echo $q->fetchJSONQnAnsforNurse();
		break;
	case 3: //fetch General QnAs with answers for nurse
	echo $q->fetchJSONQnAnsforNurseGeneral();
		break;
	case 4: //fetch Nutrition QnAs with answers for nurse
	echo $q->fetchJSONQnAnsforNurseNutrition();
		break;
	case 5: //fetch pharmaceutical QnAs with answers for nurse
	echo $q->fetchJSONQnAnsforNursePharma();
		break;
	case 6: //fetch all QnAs with answers for nurse
	echo $q->fetchJSONQnAnsforNurseRecent();
		break;
	
	default:
		echo '{"result":0,"message":"unknown command, the last one"}';
}
		
?>	