<?php
require_once 'report.php';

class eduRepo extends report
{
	
	function eduRepo()
	{
		report::report();
	}
	
	//return all educational materials in the database
	function getAllMaterials(){
		$str_query = "select TITLE,CONTENT,IMAGE,CATEGORY 
					  from educational_materials";
					  
		$exec =$this->query($str_query);
	
	if($this->get_num_rows($exec)){ 
		while($row[]=$this->fetch($exec)){
		$value['eduMaterials']=$row;
		}
		$encode = json_encode($value);
	}
	return $encode;
	}
	
	
	
	function submitMaterial(){
		if(!$this->connect())
		{
		return false;
		}
		
		$title="";
		if(isset($_REQUEST["title"])){
		$title= $_REQUEST["title"];
		}
		$content="";
		if(isset($_REQUEST["content"])){
		$content= $_REQUEST["content"];
		}
		$image="";
		if (isset($_REQUEST['image'])) {
		$image=$_REQUEST['image'];
		}
		$category="";
		if (isset($_REQUEST['category'])) {
		$category=$_REQUEST['category'];
		}
		
		$this->result=mysql_query("insert into educational_materials (MATERIAL_ID,TITLE, CONTENT,IMAGE,TIME_UPLOADED,CATEGORY) 
		VALUES ('','$title','$content', 'http://10.0.2.2/MobileWeb/ajFlow.php', NOW(),'$category')",$this->link);
		
		if($this-> result == false){
		$this -> str_error = "error while answering".mysql_error($this->link);
		return false;
		}
		return true;
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