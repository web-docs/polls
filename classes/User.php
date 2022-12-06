<?php 


class User{

    const ROLE_EMPLOYEE = 1;
    const ROLE_ADMIN = 9;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETE = 2;

    public static function create($data){
        DB::query("INSERT INTO users SET role=1, status=1, firstname=:firstname, lastname=:lastname, phone=:phone, password=:password,department_id=:department_id, created_at=NOW()",[
            'firstname'=>$data['firstname'],
            'lastname'=>$data['lastname'],
            'phone'=>correct_phone($data['phone']),
            'password'=>$data['password'],
            'department_id'=>$data['department_id']
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
		// $users = DB::query("SELECT u.*,d.title FROM users u INNER JOIN departments d ON d.id=u.department_id WHERE u.role=:role AND u.status=1 ORDER BY u.department_id,u.lastname,u.firstname",['role'=>$role]);
		$users = DB::query("SELECT * FROM users WHERE role=:role AND status=1 AND position_id in(1,2,3) ORDER BY position_id,fio_passport",['role'=>$role]);
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