<?php 


class User{

    const ROLE_EMPLOYEE = 1;
    const ROLE_ADMIN = 9;

	public static function getUsers($role=1){
		$users = DB::query("SELECT * FROM users WHERE role=:role",['role'=>$role]);
		return $users;
	}

	public static function get($id){
	    $user = DB::select("SELECT * FROM users WHERE id={$id} LIMIT 1");
	    return $user[0];
    }
	public static function getByLogin($login){
	    $user = DB::select("SELECT * FROM users WHERE phone='{$login}' LIMIT 1");
	    return $user[0];
    }

}