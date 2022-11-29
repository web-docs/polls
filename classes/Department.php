<?php 

class Department{
	
	public static function add($title){
		$result = DB::query("INSERT INTO departments SET title=:title, created_at=NOW()",['title'=>$title]);
		return $result;
	}

	public static function getList(){
	    $result = DB::query("SELECT id,title FROM departments ORDER BY title ASC");
	    return $result;
    }


}