<?php
require_once 'report.php';

class answers extends report
{
	
	function answers()
	{
		report::report();
	}
	
	//return all answers in the database
	function getAllAnswers(){
		$str_query = "select ANSWER,SPEC_NAME,ANSWER_TIME 
					  from answers,specialist 
					  where answers.SPEC_USERNAME = specialist.SPEC_USERNAME";
		$exec=$this->query($str_query);
		if(!$exec)
		{
			return false;
		}
		
		return $exec;	
	}
	
	function fetchJSONanswers(){
	$str_query =("select ANSWER,SPEC_NAME,ANSWER_TIME 
				  from answers,specialist 
				  where answers.SPEC_USERNAME = specialist.SPEC_USERNAME");

	$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['answerDetails']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	//return an answer that is identified by the question id/ keyword 
	function getAnswer($spec_id)
	{
		if(!$this->connect())
		{
			return false;
		}
		$this->result=mysql_query("select ANSWER from answers where SPEC_USERNAME='A3356B'",$this->link);
		
		if($this->result==false)
		{
			$this->str_error="error while fetching answer. ".mysql_error($this->link);
			return false;
		}
		return $this->result;	
		
	}
	
	function answerQuestion($answer,$spec_id,$question_id){
		if(!$this->connect())
		{
		return false;
		}
		
		$answer="";
		if(isset($_REQUEST["answer"])){
		$answer= $_REQUEST["answer"];
		}
		$category="";
		if(isset($_REQUEST["category"])){
		$category= $_REQUEST["category"];
		}
		$question_id="";
		if(isset($_REQUEST["question_id"])){
		$question_id= $_REQUEST["question_id"];
		}
		$spec_id="";
		if (isset($_SESSION['userid'])) {
		$spec_id=$_SESSION['userid'];
		}
		
		$this->result=mysql_query("insert into answers (ANSWER_ID, ANSWER,IMAGE,ANSWER_TIME,SPEC_USERNAME,QUESTION_ID,CATEGORY) 
		VALUES ('','$answer', NULL, NOW(), '$spec_id','$question_id','$category')",$this->link);
		
		if($this-> result == false){
		$this -> str_error = "error while answering".mysql_error($this->link);
		return false;
		}
		return true;
		}
		
	function getGeneralAnswers(){
		$str_query=("SELECT QUESTION, FIRSTNAME, LASTNAME,questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'GENERAL'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
				
	$exec =$this->query($str_query);
	//$result= array();
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['general']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function getNutritionalAnswers(){
		$str_query=("SELECT QUESTION, FIRSTNAME, LASTNAME,questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'NUTRITION'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
	$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['nutrition']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function getPharmaceuticalAnswers(){
		$str_query=("SELECT QUESTION, FIRSTNAME, LASTNAME, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'PHARMACEUTICAL'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
							

	$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['pharmaceutical']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	
	function getRecord()
	{	
		$row=mysql_fetch_assoc($this->result);
		if(!$row)
		{
			$this->str_error="error while fetching. ".mysql_error($this->link);
			return false;
		}
		return $row;
	}
	
	function getError()
	{
		return $this->str_error;
	}
}
?>