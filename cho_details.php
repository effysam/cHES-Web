<?php
if(!isset($_REQUEST['cmd'])){
	echo '{"result":0,"message":"unknown command"}';
	exit();
}
	$cmd=$_REQUEST["cmd"];
	include 'cho.php';
	$q= new cho();
	switch($cmd)
	{
	case 1:
	//authenticate Nurse
		session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();

	/* set the cache expire to 30 minutes */
	session_cache_expire(1);
	$cache_expire = session_cache_expire();

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will prompt user to sign in(jump to login page)
	/*
	if (!isset($_SESSION['userid'])) {
		//header('Location: login_specialist.php');
		echo "Please sign in to access this feature";
	}*/
	
	/*$nurseId="";
		if (isset($_SESSION['userid'])) {
		$nurseId=$_SESSION['userid'];
		}
	*/	
		$q->loginNurse();
		break;

	}
?>