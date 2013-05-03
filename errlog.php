<?php
/**
*author: Nii Sowah Kakai Adapted from Aelaf T Dafla
*date:
*/
//aelaf:use constants defined in this file to connect to database


define("ERLOG_HOST","localhost");
define("ERLOG_DATABASE",'commhealth_logs');
define("ERLOG_USER",'errlogger');//to be changed
define("ERLOG_PASSWORD",'errlogger');
define("ERLOG_PORT",3306);

define("ER_MYSQL", 3000);
define("ER_LOG_ERROR",2100);
define("ER_CHO",4200);          //aelaf: new definitions
define("ER_MESSAGE",4300);     //aelaf: new definitions
define("ER_DISTRICT",4400);		//ADDED err_code_prefix for DISTRICT
define("ER_COMMUNITY",4500);		//ADDED err_code_prefix for COMMUNITY
define("ER_SEARCH",4600);		//
define("LOG_LEVEL_CRITICAL",0);
define("LOG_LEVEL_SEC",0);
define("LOG_LEVEL_DB_FAIL",0);
define("LOG_LEVEL_TRN_SUCC",0);
define("LOG_LEVEL_TRN_FAIL",0);
define("LOG_LEVEL_WRRNING",5);
define("LOG_LEVEL_SUCCESS",7);
define("LOG_LEVEL_SUCCESS_LOW",8);
define("LOG_LEVEL_BANK_ERROR",8);


/*
*Connect to log database to log error
*/
function init_connection_to_log()
{
    //connect to log host
    //aelaf:replace this variables with cosntants in config.php
    $link=@mysql_connect(ERLOG_HOST,ERLOG_USER,ERLOG_PASSWORD);
    if(!$link)
    {
        //log error into text file
        log_logger_error(LOG_LEVEL_CRITICAL,ER_LOG_ERROR+1,"Could not connect to log database" );
        return false;
    }
    
    //select error logging database
    if(!mysql_select_db(ERLOG_DATABASE,$link))
    {
        //log error into text file
        log_logger_error(LOG_LEVEL_CRITICAL,ER_LOG_ERROR+2,"Could not select log database". mysql_error($link));
        die($link);
        return false;
    }
    return $link;
}

/*
* log error with database, error message includes current username, host name, time, file it origninated
* param $level severity of error
* param $code unique code of the error
* param $msg error message
* param $mysql_msg error message from sql server, default value 'NONE'
*/
function log_msg($level,$code,$msg,$mysql_msg='NONE')
{
    
    $link=init_connection_to_log();
    if(!$link)
    {
        //error has been logged by init_connection_to_log
        return false;
    }
    
  
    $username="";
    //if user has already logged in use the username
    //if user has not loged in use unknown as user name
    if(!isset($_SESSION['UR_USERNAME']))
    {
        $username="unknown";
    }
    else
    {
        $username=$_SESSION['UR_USERNAME'];
    }
    
    if(!isset($_SESSION['UR_FDOMAIN']))
    {
        $domain="unknown";
    }
    else
    {
        $domain=$_SESSION['UR_FDOMAIN'];
    }
    $mysql_msg=str_replace("'","%",$mysql_msg);
	$mysql_msg=str_replace('"',"%",$mysql_msg);
	
	$mysql_msg = mysql_real_escape_string($mysql_msg);
        //aelaf check if this sql matches the database
    $str_query="INSERT INTO logs SET " .
	    "LOG_CODE=$code, ".
	    "USERNAME='$username', ".
	    "DOMAIN='$domain', ".
	    "HOST='" . $_SERVER['HTTP_HOST']."',".
	    "PAGE_URI='" . $_SERVER['SCRIPT_FILENAME']."',".
	    "LOG_MSG='mysql_real_escape_string($msg)',".
	    "MYSQL_MSG='$mysql_msg'";
    
    
    if(!mysql_query($str_query,$link))
    {
        //log error in text file
        log_logger_error(0,ER_LOG_LOGGER+3,"Could not insert log into table :" . mysql_error($link));
        return false;
    }

    return mysql_insert_id($link);
    //return true;
}

/**
*this function is invoked if error could not be logged into database
*it writes error message into text file
*/
function log_logger_error($level,$code,$msg)
{
     //open text file in append text mode
     //On the Windows platform, be careful to escape any backslashes used in the path to the file, or use forward slashes.
    $fhandle=fopen('logs.txt',"at");

    $username="";
    //current day and time
	$str_date= date(" d/m/Y H:i:s") ;
	
	if(isset($_SESSION['UR_USERNAME']))
	{
		$username=$_SESSION['UR_USERNAME'];
	}
	else
	{
		$username="unknown";
	}

       //compile text line. $log_msg is formatted for writing into text file
	$log_msg=sprintf("E%d : %-10s, %-15s , %-30s, %s \n", $code, $str_date, $username, $_SERVER['HTTP_HOST'],$msg);

    //write line
	fwrite($fhandle,$log_msg);
	//close file
	fclose($fhandle);

}
?>
