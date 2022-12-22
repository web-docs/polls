<?php

// error_reporting(E_ALL);

session_start();

function autoLoader($name) {
    require 'classes/'.$name.'.php';
}

spl_autoload_register('autoLoader');
$locales = [];
if($_SESSION['lang']=='en') {
    $locales = include('lang/en.php');
}

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

function __($text){
    global $locales;
    if(isset($locales[$text])){
        return $locales[$text];
    }
    return $text;
}
