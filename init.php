<?php

session_start();

set_include_path(get_include_path() . '/classes' );

spl_autoload_extensions('.php');

spl_autoload_register();

DB::init();

if(isset($_GET['logout'])){
    Auth::logout();
}


function d($data,$exit=false){
	
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if($exit) exit;
	
}

function correct_phone($phone){
    $phone = preg_replace('/[^0-9]/','',$phone);
    return $phone;
}
