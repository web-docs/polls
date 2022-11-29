<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to, created_at=NOW()",['user_from'=>$user_from,'user_to'=>$user_to]);
		return $result;
	}

	public static function stat($id){
	    $user = DB::select("SELECT * FROM polls WHERE id={$id} LIMIT 1");
	    return $user[0];
    }


}