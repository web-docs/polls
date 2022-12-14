<?php
require 'init.php';

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];

}else{
    $_SESSION['lang'] = 'ru';
}

header('location:login.php');
exit;

