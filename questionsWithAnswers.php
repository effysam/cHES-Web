<?php
require_once 'report.php';

class questionsWithAnswers extends report
{
	
	function questionsWithAnswers()
	{
		report::report();
	}
	
	function fetchJSONquestionsWithAnswers(){
	$str_query=("
				CREATE OR REPLACE VIEW question_answer AS
				SELECT questions.QUESTION_ID, QUESTION, FIRSTNAME, LASTNAME,questions.TIME,ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID
				");
		
		$str_query_join =("SELECT * 
						   FROM question_answer
						   RIGHT JOIN questions
						   ON question_answer.QUESTION_ID=questions.QUESTION_ID						   
							");
		
	$exec =$this->query($str_query_join);
	$exec_join =$this->query($str_query_join);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function fetchJSONQnAnsforNurse(){
	$nurse_id = $_GET['username'];
	
		$str_query=("SELECT QUESTION, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE CHUSERNAME= '$nurse_id'
				AND questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
							
				
	$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function fetchJSONQnAnsforNurseGeneral(){
	$nurse_id = $_GET['username'];
	
		$str_query=("SELECT QUESTION, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE CHUSERNAME= '$nurse_id'
				AND questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'GENERAL'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
							
				
	$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function fetchJSONQnAnsforNurseNutrition(){
	$nurse_id = $_GET['username'];
	
		$str_query=("SELECT QUESTION, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE CHUSERNAME= '$nurse_id'
				AND questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'NUTRITION'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
							
				
	$exec =$this->query($str_query);
	//$result= array();
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	function fetchJSONQnAnsforNursePharma(){
	$nurse_id = $_GET['username'];
	
		$str_query=("SELECT QUESTION, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE CHUSERNAME= '$nurse_id'
				AND questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				AND answers.CATEGORY = 'PHARMACEUTICAL'
				ORDER BY questions.TIME,answers.ANSWER_TIME,answers.QUESTION_ID");
							
				
	$exec =$this->query($str_query);
	//$result= array();
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
		function fetchJSONQnAnsforNurseRecent(){
	$nurse_id = $_GET['username'];
	
		$str_query=("SELECT QUESTION, questions.TIME, ANSWER, SPEC_NAME, answers.ANSWER_TIME 
				FROM questions, community_health_officer, answers, specialist
				WHERE CHUSERNAME= '$nurse_id'
				AND questions.QUESTION_ID = answers.QUESTION_ID
				AND community_health_officer.NURSE_ID = questions.NURSE_ID
				AND answers.SPEC_USERNAME = specialist.SPEC_USERNAME
				ORDER BY questions.TIME DESC");
							
				
	$exec =$this->query($str_query);
	//$result= array();
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['QnAs']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
}
?>