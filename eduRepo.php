<?php
//handler for educational_materials
if(!isset($_REQUEST['cmd'])){
	echo '{"result":0,"message":"cmd is not set"}';
	exit();
}
$cmd=$_REQUEST["cmd"];
include 'educationalRepo.php';
$q= new eduRepo();
switch($cmd)
{
	case 1://fetch all questions and answers to them
		echo $q->getAllMaterials();
		break;
	
	case 2: //Insert educational material
	/* set the cache limiter to 'private' */
		$q->submitMaterial();
		break;

	default:
		echo '{"result":0,"message":"unknown command, the last one"}';
}
		
?>	