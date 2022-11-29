<?php 

class Poll{
	
	public static function add($user_from,$user_to){
		$result = DB::query("INSERT INTO polls SET user_from=:user_from, user_to=:user_to",['user_from'=>$user_from,'user_to'=>$user_to]);
		echo 'add poll ';
		d($result);
		return $result;
	}

	/*public static function get($id){
	    $user = DB::select("SELECT * FROM users WHERE id={$id} LIMIT 1");
	    return $user[0];
    }
	public static function getByLogin($login){
	    $user = DB::select("SELECT * FROM users WHERE phone='{$login}' LIMIT 1");
	    return $user[0];
    }*/

}