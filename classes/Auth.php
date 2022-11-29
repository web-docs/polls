<?php 

class Auth{
	
	public static function id(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['id'];
        }
        return false;
	}

	public static function user(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        return false;
	}

    public static function login(){
        $data = $_POST;
	    $user = User::getByLogin($data['login']);
	    if($user['password']==md5($data['password'])){
            $_SESSION['login'] = true;
            unset($user['password']);
            $_SESSION['user'] = $user;
	        return true;
        }
	    return false;
    }
    public static function logout(){
        unset($_SESSION['login']);
        unset($_SESSION['user']);
        header('location: /');
        exit;
    }

    public static function check(){
        if(isset($_SESSION['login']) && $_SESSION['login']) return true;
	    return false;
    }
    public static function redirect($route){
        header('location: ' . $route);
        exit;
    }
}