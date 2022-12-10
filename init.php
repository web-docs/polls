<?php

// error_reporting(E_ALL);

session_start();

function autoLoader($name) {
    require 'classes/'.$name.'.php';
}

spl_autoload_register('autoLoader');

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
