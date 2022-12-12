<?php

return [

	'db'=>[
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => $_SERVER['HTTP_HOST']=='polls.loc' ? '':'',
		'dbname' => 'polls',
	]

];