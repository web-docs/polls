<?php 


class User{

    const ROLE_EMPLOYEE = 1;
    const ROLE_ADMIN = 9;

	public static function getUsers($role=1){
		$users = DB::query("SELECT u.*,d.title FROM users u INNER JOIN departments d ON d.id=u.department_id WHERE u.role=:role",['role'=>$role]);
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