<?php
require_once 'report.php';

class questions extends report
{
	
	function questions()
	{
		report::report();
	}

	//ask a question
	function askQuestion($question,$nurse_id){
		if(!$this->connect())
			{
			return false;
			}

			$question = $_GET['question'];
			$nurse_id = $_GET['username'];
		
		$this->result=mysql_query("insert into questions (QUESTION_ID,QUESTION,IMAGE,TIME,NURSE_ID)
					 values('','$question',NULL,NOW(),
					 (SELECT NURSE_ID FROM community_health_officer where CHUSERNAME= '$nurse_id'))",$this->link);
					 
										
		if($this-> result == false){
			$this -> str_error = "error while asking question".mysql_error($this->link);
			return false;
			}
			return true;
			}
			
		function fetchJSONquestions(){
			$str_query=("SELECT QUESTION_ID, QUESTION, FIRSTNAME, LASTNAME, questions.TIME 
						FROM questions, community_health_officer
						WHERE  community_health_officer.NURSE_ID = questions.NURSE_ID");
															
			$exec =$this->query($str_query);
			
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