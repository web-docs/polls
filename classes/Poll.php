<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to, created_at=NOW()",['user_from'=>$user_from,'user_to'=>$user_to]);
		return $result;
	}

	public static function stat(){
	    $result = DB::query("SELECT  p.user_to, COUNT(p.user_from) AS cnt,u.firstname,u.lastname FROM polls p INNER JOIN users u ON u.id=p.user_to GROUP BY p.user_to ORDER BY cnt DESC,p.created_at ASC");	    return $result;
    }


}