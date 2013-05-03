<?php

require_once 'adb.php';

/**
  author: Adapted from Aelaf T Dafla
  date: 3-6-2011
  description: Parent class for all reporting/viewing functions/classes. 
  This class is used in genrating reports. it extends adb.php
 */

class report extends adb{


    var $rec;
    var $num_recs;
    var $offset;
    var $limit;
    var $cur_query;
    var $style_title;
    var $style_line1;
    var $style_line2;
    var $style_line;
    var $type;
    var $counter;
    var $page;
    var $tb;
    var $object_id;

    function report($id="REP") {
        adb::adb();
        $this->offset = 0;
        $this->limit = 2;
        $this->counter = 0;
        
	//this will be replaced with a separate style file/function later
        $this->style_title = "default_report_title";
        $this->style_line1 = "default_report_line1";
        $this->style_line2 = "default_report_line2";

        $this->object_id=$id;
    }

    function set_result($result) {
        $this->result = $result;
    }

    //aelaf simplified fetch function
    //for the sake of this fucntion, class.adb.php->fetch() was commented
    function fetch() {
        $this->counter++;
        return mysql_fetch_assoc($this->result);
    }
    
  /*  //nii fetch to return a JSON Object
    function fetchJSON() {
    	return json_encode(mysql_fetch_assoc($this->result));
    }
    */
    
	//aelaf:added this function
    function get_style(){
		if ($this->counter % 2) {
           return $this->style_line1;
        } 
		
		return  $this->style_line2;
	}
    function save_query($query, $of, $lm, $page=1) {
        $_SESSION[$this->object_id]['QUERY'] = $query;
        $_SESSION[$this->object_id]['OFFSET'] = $of;
        $_SESSION[$this->object_id]['LIMIT'] = $lm;
        $_SESSION[$this->object_id]['PAGE'] = $page;
    }

    function get_saved_query() {
        return $_SESSION[$this->object_id]['QUERY'];
    }

    function next() {
        return $this->re_query(1);
    }

    function prev() {
        return $this->re_query(2);
    }

    function init_query($str_query) {
        $this->save_query($str_query, $this->offset, $this->limit);
        $query_result = $this->query($str_query . " LIMIT {$this->offset} , {$this->limit} ");
        if ($query_result) {
            $n = $this->get_num_rows();
            if ($n < $this->limit) {
                /* the value of page is just a flag.
                 * 1-in the first page. 2-in between pages. 3-last page . 4-one page
                 */
            	//you have one page. 
                $this->page = 4;
            } else {
                $this->page = 1; //you are in first page
            }
        }

        $_SESSION[$this->object_id]['PAGE'] = $this->page;
        return $query_result;
    }

    function re_query($dir) {

        $query = $_SESSION[$this->object_id]['QUERY'];
        $of = $_SESSION[$this->object_id]['OFFSET'];
        $lm = $_SESSION[$this->object_id]['LIMIT'];
        $page = $_SESSION[$this->object_id]['PAGE'];

        //echo "off=$of,limit=$lm, page=$page|";
        if ($dir == 1) { //next
            //if you are not in the last page
            if ($page != 3) {
                $of = $of + $lm;
                $page = 2;
            }
        } elseif ($dir == 2) { //prev

            if ($page != 1) { //if you are not in the first page
                $of = $of - $lm;
                $page = 2;
            }

            if ($of <= 0) { //if you have reached the first page
                $of = 0;
                $page = 1; //you are in first page
            }
        }

        //echo "off=$of,limit=$lm, page=$page |";
        $str_query = $query . " LIMIT $of, $lm ";
        $rs = $this->query($str_query);

        //echo $str_query;
        if ($rs) {
            $n = $this->get_num_rows();
            if ($n < $lm) {
                //you are in last page
                $page = 3;
            }
        }
        //echo "off=$of,limit=$lm, page=$page ";
        $_SESSION[$this->object_id]['OFFSET'] = $of;
        $_SESSION[$this->object_id]['LIMIT'] = $lm;
        $_SESSION[$this->object_id]['PAGE'] = $page;
        $this->page = $page;
        return $rs;
    }
}

?>
