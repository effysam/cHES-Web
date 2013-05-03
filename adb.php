<?php 
define("DB_HOST","localhost");
define("DB_DATABASE",'communityhealth');
define("DB_USER",'root');
define("DB_PASSWORD",'optimus1');
define("DB_PORT",3306);

require_once 'errlog.php';



/**
 * Class adb provides database connectivity and querying functions
 * To use this class, first provide server and database details into member variables declared:
 * 			$hostname, $username, etc.
 */

class adb{
	//Database connection / query functions. 
 
 var $link; //connection status[true/false]
 var $result;
 var $error_str;
 /*error code*/
 var $error;
 /* Every error log has a 4 digit code. The first two digits(prefix) tells you which class logged the error*/
 var $er_code_prefix;

 
 function adb(){
 	
 	$this->link=false;
 	$this->result=false;
 	$this->err_code_prefix=1000;
 }
 /**
  * set_credentials() is an optional function sets credentials for database server.
  */
 function set_credentials($hostname,$username,$password)
 {
   $this->hostname = $hostname;
   $this->username = $username;
   $this->password = $password;
 }
                         
 /**
  * connect():: function that establishes connection with the database server.
  * it returns a boolean value of true if connection is successfully established.
  * otherwise, a value of false is returned with error details captured into $error_str
  */
function connect()
 {
 	$log_id=0;
   if($this->link){
   		return true;
   }
   $this->link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
   
   //if port is set to default, this line can be used to connected to the server.
   //$this->link = mysql_connect($this->hostname.':'.DB_PORT, $this->username, $this->password);
   
   if(!$this->link)
   {
		//echo 'cannot connect to database server';//for debugging purpose
		
		//log this error into errlog.php
		$this->error_str = 'MySQL Error No.: '.mysql_errno($this->link).' has occured. Error Message: '
							.mysql_error($this->link); 
   		$this->log_error(LOG_LEVEL_DB_FAIL, 1, "Could not connect to DB in adb::connect()", $this->error_str);
		return false;
   }  
   if (!mysql_select_db(DB_DATABASE, $this->link))
   {
		//echo 'cannot connect to database: '.DB_DATABASE;//for debugging purpose
		
		//log this error into log.php
		$this->error_str = 'MySQL Error No.: '.mysql_errno($this->link).' has occured. Error Message: '
							.mysql_error($this->link);   		
   		$this->log_error(LOG_LEVEL_DB_FAIL, 2, "Could not select DATABASE in adb::connect()", $this->error_str);
		die($this->link);
		return false;   	
   }                                                  
 return true;
 }
 
/**
  * logs error into database using functions defined in log.php
*/
function log_error($level, $code, $msg, $mysql_msg = "NONE") {
  $er_code = $this->er_code_prefix + $code;
  $log_id = log_msg($level, $er_code, $msg, $mysql_msg);
  
  //if log id is false return 0;
  if (!$log_id) {
    return 0;
  }

  //display this code to user
  $this->error="$er_code-$log_id";
  return $log_id;
}
                         

 
                         
 function query($query_str)
 {
 	if (!$this->connect()) {
 		return false;
 	}
 	
 	
 	$this->result=mysql_query($query_str);
 	
 	if(!$this->result){
 		
 		$this->error_str='MySQL Error No.: '.mysql_errno($this->link).' has occured. Error Message: '.mysql_error($this->link);   		
   		$this->log_error(LOG_LEVEL_DB_FAIL, 4, "Could not query the selected database in db::connect()", $this->error_str);
 		die($this->link);
 		return false;   
 	}
 	
 	return $this->result;
 }
/* 
function fetch(){
	return mysql_fetch_assoc($this->++);
}
*/
function free_result() {
	if (!$this->result) {
		return ;
	}
	mysql_free_result($this->result);
}

function get_num_rows() {
   return mysql_num_rows($this->result);
}

function get_insert_id() {
   return mysql_insert_id($this->link);
}

}
?>