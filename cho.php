	<?php
//change table name to community_health_officer
include_once ("report.php");
/**
 * Class for community health officer entity. extends report class
 * @filesource cho.php
 * @author
 */
class cho extends report
{
        /**
         * Constructor
         */
	function cho()
	{
		report::report();
		$this->er_code_prefix=ER_CHO;
	}
	/**
         *Adds a CHO to db
         * @param string $firstname
         * @param string $lastname
         * @param string $chusername
         * @param string $pword
         * @param int $communityId
         * @param int $jobdesid
         * @return boolean
         */
	function addCHO($firstname, $lastname, $chusername, $pword, $communityId, $jobdesid)
	{
		$str_query = "INSERT INTO community_health_officer (FIRSTNAME, LASTNAME, CHUSERNAME, PWORD, COMMUNITYID, JOBDESID)
				VALUES('$firstname', '$lastname', '$chusername', '$pword', '$communityId', '$jobdesid')";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	
	/**
         *Get a CHO identified by id
         * @param int $choID
         * @return array
         */
	function getCHO($choID)
	{
		$str_query = "SELECT NURSE_ID, FIRSTNAME, LASTNAME, CHUSERNAME FROM community_health_officer WHERE NURSE_ID='$choID'";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		$row = $this->fetch();
		return $row;
	}
	/**
         *Gets all CHOs in a district identified ID. Call fetch to get record as array
         * @param int $districtID
         * @return bool
         */
	function getCHOd($districtID)
	{
		$str_query = "SELECT NURSE_ID, FIRSTNAME, LASTNAME, CHUSERNAME FROM community_health_officer h
				INNER JOIN (community c, district d)
				ON (h.COMMUNITYID = c.COMMUNITYID) AND (c.DISTRICTID=d.DISTRICTID)
				WHERE d.DISTRICTID='$districtID'
				GROUP BY NURSE_ID;";
		$exec=$this->init_query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	/**
         *Get all CHOs in a community identfied by ID
         * @param int $communityID
         * @return bool
         */
	function getCHOc($communityID)
	{
		$str_query = "SELECT NURSE_ID, FIRSTNAME, LASTNAME, CHUSERNAME, c.COMMUNITYID FROM community_health_officer h
				LEFT OUTER JOIN community c ON (h.COMMUNITYID = c.COMMUNITYID)
				WHERE c.COMMUNITYID='$communityID'
				GROUP BY NURSE_ID";
		$exec=$this->init_query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	/**
         *Update CHO data identfied by ID
         * @param <type> $choID
         * @param <type> $lastname
         * @param <type> $firstname
         * @param <type> $username
         * @param <type> $commID
         * @return bool
         */
	function updateCHO($choID,$lastname,$firstname,$username,$commID)
	{
		$str_query = "UPDATE community_health_officer SET LASTNAME='$lastname', FIRSTNAME='$firstname', CHUSERNAME='$username', COMMUNITYID=$commID WHERE NURSE_ID=$choID";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	/**
         *Gets all CHOs
         *@return bool
         */
	function getAllCHO()
	{
		$str_query = "SELECT NURSE_ID, LASTNAME, FIRSTNAME, CHUSERNAME, COMMUNITYID FROM community_health_officer GROUP BY NURSE_ID";
	 	$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		return $this->result;
	}
	/**
         *Gets all CHOs using limit clause, that is init_query function. Call fetch functions to get record.
         * @return bool
         */
	function getAllCHO_Limit()
	{
	    $str_query = "SELECT NURSE_ID, LASTNAME, FIRSTNAME, CHUSERNAME, COMMUNITYID FROM community_health_officer GROUP BY NURSE_ID";
	    $exec=$this->init_query($str_query);
	    if(!$exec)
	    {
			return false;
	    }
	    return true;
	}
	
	//login 
	function loginNurse(){
	
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		
		$str_query = ("SELECT CHUSERNAME
						FROM community_health_officer 
						WHERE (CHUSERNAME = '$username')
						and (PWORD = '$password')");
		
		$exec=$this->query($str_query);
	   if(!$exec)
	    {
			return false;
	    }
		//echo $exec;
		while ($row = mysql_fetch_array($exec)){
		echo $row[0];
		
		$row = mysql_fetch_array($exec);
		}
	    return $exec;
			}
	/**
         *fetchs the current CHO record and return it as JSON
         * @return JSON object of the current  CHO record in record set
         */
	function fetchJSONcho()
	{
		$row=$this->fetch();
		if(!$row)
		{
			return false;	
		}
                /**
                 * @todo define standard cho object
                 */
		$str='{"nurseID":'.$row["NURSE_ID"].', "lastname":'.'"'.$row["LASTNAME"].'"'.',"firstname":'.'"'.$row["FIRSTNAME"].'"'.',"chusername":'.'"'.$row["CHUSERNAME"].'"'.',"commid":'.$row["COMMUNITYID"].'}';
		return $str;
	}
	
}
?>