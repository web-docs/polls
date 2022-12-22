<?php 

class Auth{
	
	public static function id(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['id'];
        }
        if(isset($_COOKIE['user'])){
            $user = Auth::user();
            return $user['id'];
        }
        return false;
	}

	public static function user(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        if(isset($_COOKIE['user'])){
            $user = json_decode($_COOKIE['user'],true);
            return $user;
        }

        return false;
	}

    public static function login(){
        $data = $_POST;
        $phone = correct_phone($data['login']);
	    $user = User::getByLogin($phone);
	    if($user['password']==md5($data['password'])){
            Auth::sessionClear();
            $_SESSION['login'] = true;
            unset($user['password']);
            $_SESSION['user'] = $user;

            setcookie('login',true);
            setcookie('user',json_encode($user,JSON_UNESCAPED_UNICODE));

	        if($user['status']==User::STATUS_COMPLETE){
                Auth::redirect('complete.php');
            }
	        return $user;
        }
	    return false;
    }

    public static function register(){
	    Auth::sessionClear();
        $data = $_POST;

        if( $user = User::getByLogin($data['phone']) ){
            $_SESSION['error'] = 'Данный телефон уже имеется в системе, укажите другой!';
            return false;
        }

        $uploaddir = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].'/assets/photo/' : 'assets/photo/';
        $uploadfile = $uploaddir . $data['phone'] . '.jpg';

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
            $_SESSION['error'] = 'Ошибка файла, укажите другой!';
            return false;
        }

        $data['password'] = md5($data['password']);
        $user = User::create($data);

        //$_SESSION['login'] = true;
        //unset($user['password']);
        //$_SESSION['user'] = $user;
        $_SESSION['info'] = 'Регистрация прошла успешно!';

        return true;
    }

    public static function logout($route='/'){
        Auth::sessionClear();
        header('location: ' . $route);
        exit;
    }

    public static function check(){
        if((isset($_SESSION['login']) && $_SESSION['login'] && (isset($_SESSION['user']) && $_SESSION['user']['status']==User::STATUS_ACTIVE) || $_SESSION['user']['role'] == User::ROLE_ADMIN )) {
            return true;
        }

        if(isset($_COOKIE['login']) && $_COOKIE['login']) return true;

	    return false;
    }

    public static function complete(){
        if(isset($_SESSION['user']) && $_SESSION['user']['status']==User::STATUS_COMPLETE) return true;

        $user = Auth::user();
        if( $user && $user['status']==User::STATUS_COMPLETE) {
            setcookie('user',false,0);

            return true;
        }

	    return false;
    }

    public static function sessionClear(){
        unset($_SESSION['login']);
        unset($_SESSION['user']);
        unset($_SESSION['error']);
        unset($_SESSION['info']);
        setcookie('login',false);
        setcookie('user',false,0);
    }

    public static function redirect($route){
        header('location: ' . $route);
        exit;
    }
}