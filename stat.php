<?php

require ('init.php');

if(!Auth::check()){
    Auth::redirect('login.php');
}



$result = Poll::stat();

d($result);
