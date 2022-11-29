<?php 
require ('init.php');

if(!Auth::check()){
    Auth::redirect('login.php');
}else{
   Auth::redirect('poll.php');
}
