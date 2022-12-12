<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to, created_at=NOW()",['user_from'=>$user_from,'user_to'=>$user_to]);
		return $result;
	}

	public static function stat(){
	    $result = DB::query(" SELECT u.id, p.cnt,u.fio_passport,u.position,u.position_id
                 FROM (
                     SELECT COUNT(p.user_to) as cnt, p.user_to FROM polls p
                     GROUP BY p.user_to
                     ORDER BY cnt DESC
                 ) AS p
                
                 INNER JOIN users u ON u.id=p.user_to 
                 WHERE u.position_id in (1,2,3)  
                 ORDER BY u.position_id ASC, cnt DESC");
        return $result;
    }
    


}