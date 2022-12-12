<?php 


class User{

    const ROLE_EMPLOYEE = 1;
    const ROLE_ADMIN = 9;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETE = 2;

    public static function create($data){
        DB::query("INSERT INTO users SET role=1, status=1, fio_passport=:fio_passport, fio=:fio, phone=:phone,department=:department, password=:password,position_id=:position_id,position=:position, created_at=NOW()",[
            'fio_passport'=>$data['fio_passport'],
            'fio'=>$data['fio'],
            'phone'=>correct_phone($data['phone']),
            'password'=>$data['password'],
            'department'=>$data['department'],
            'position'=>$data['position'],
            'position_id'=>$data['position_id'],
        ]);
        $user = false;
        if(!isset($_SESSION['error'])){
             $user = User::getByLogin($data['phone']);
        }

        return $user;
    }
    public static function setStatus($id,$status){
        DB::query("UPDATE users SET status=:status,updated_at=NOW() WHERE id=:id",[
            'status'=>$status,
            'id'=>$id
        ]);
        $_SESSION['user']['status'] = $status;
        return true;
    }
    
	public static function getUsers($role=1){
		$users = DB::query("SELECT * FROM users WHERE role=:role AND status=1 AND position_id in(1,2,3) ORDER BY position_id,fio_passport",['role'=>$role]);
		//d($users,1);
		return $users;
	}

	public static function get($id){
	    $user = DB::query("SELECT * FROM users WHERE id={$id} LIMIT 1");
	    return $user[0];
    }
	public static function getByLogin($login){
	    $user = DB::query("SELECT * FROM users WHERE phone='{$login}' LIMIT 1");
	    return $user[0];
    }

}