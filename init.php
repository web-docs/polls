<?php

session_start();

set_include_path(get_include_path() . '/classes' );

spl_autoload_extensions('.php');

spl_autoload_register();

DB::init();

function d($data,$exit=false){
	
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if($exit) exit;
	
}
