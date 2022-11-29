<?php 
require ('init.php');

if(isset($_GET['logout'])){
    Auth::logout();
}


if(!Auth::check()){
    Auth::redirect('login.php');
}else{
   Auth::redirect('poll.php');
}
