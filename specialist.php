<?php
include_once ("report.php");
/**
 * Class for specialist entity. extends report class
 * @filesource specialist.php
 * @author
 */
class specialist extends report
{
        /**
         * Constructor
         */
	function specialist()
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
	function addSpecialist($spec_username, $pword, $spec_name, $pword, $spec_hospital)
	{
		$str_query = "INSERT INTO specialist (SPEC_ID,SPEC_USERNAME, SPEC_PASSWORD, SPEC_NAME, SPEC_HOSPITAL)
				VALUES('','$spec_username', '$pword', '$spec_name', '$pword', '$spec_hospital')";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	
	/**
         *Get a Specialist identified by username
         * @param int $choID
         * @return array
         */
	function getSpecialist($spec_username)
	{
		$str_query = "SELECT SPEC_USERNAME, SPEC_NAME, SPEC_HOSPITAL  FROM specialist WHERE SPEC_USERNAME='$spec_username'";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		$row = $this->fetch();
		return $row;
	}
	
	function updateSpecialist($spec_username,$spec_name,$spec_hospital)
	{
		$str_query = "UPDATE specialist SET LASTNAME='$lastname', FIRSTNAME='$firstname', CHUSERNAME='$username', COMMUNITYID=$commID WHERE NURSE_ID=$choID";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		else return true;
	}
	
}