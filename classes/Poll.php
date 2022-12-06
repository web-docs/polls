<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to, created_at=NOW()",['user_from'=>$user_from,'user_to'=>$user_to]);
		return $result;
	}

	public static function stat($limit=3){
	    $result = DB::query("SELECT u.id, p.user_to, COUNT(p.user_from) AS cnt,u.fio_passport,u.position,u.position_id FROM polls p INNER JOIN users u ON u.id=p.user_to and u.position_id in (1,2,3) where u.position_id in (1,2,3)  GROUP BY u.position_id, p.user_to ORDER BY cnt DESC,p.created_at ASC,p.created_at ASC LIMIT {$limit}");
        return $result;
    }
    


}