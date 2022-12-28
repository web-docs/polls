<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to, created_at=NOW()",['user_from'=>$user_from,'user_to'=>$user_to]);
		return $result;
	}

	public static function stat($position=[1,2,3],$limit=1000){

        if(is_array($position)) {
            $position = implode(',', $position);
        }

	    $result = DB::query(" SELECT u.id, p.cnt,u.fio_passport,u.position,u.position_id,u.phone
                 FROM (
                     SELECT COUNT(p.user_to) as cnt, p.user_to FROM polls p
                     GROUP BY p.user_to
                     ORDER BY cnt DESC
                 ) AS p                
                 INNER JOIN users u ON u.id=p.user_to 
                 WHERE u.position_id in ({$position})                
                 ORDER BY u.position_id ASC, cnt DESC
                 LIMIT {$limit}");
        return $result;
    }

    public static function votes(){
        $result = DB::query("SELECT u.id, user_from,user_to,u.fio_passport uto,u.phone,u.position,u.position_id,u2.fio_passport AS ufrom, u2.position uposition,u2.phone
                 FROM (
                     SELECT p.user_to,p.user_from FROM polls p
                 ) AS p                
                 left JOIN users u ON u.id=user_to 
                 left JOIN users u2 ON u2.id=user_from 
                 WHERE u.position_id in (1,2,3)                
                 ORDER BY u.position_id ASC, user_to ASC");
        return $result;
    }


}