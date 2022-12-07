<?php
require('init.php');

if (!Auth::check()) {
    Auth::redirect('login.php');
}

$limit = 1000;
$users = Poll::stat($limit);
$cnt = 0;
foreach($users as $user) {
    $cnt += $user['cnt'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bucheon University in Tashkent | Complete</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<div class="snowing">
    <div class="small-snow-left">
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
    </div>
    <div class="small-snow-right">
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
        <div class="small"></div>
    </div>
    <div class="medium-snow-left">
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
    </div>
    <div class="medium-snow-right">
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
        <div class="medium"></div>
    </div>
</div>
<div class="juniper">
    <h1>Спасибо! Ваш голос учтен!</h1>
    <div class="juniper-img">
        <img src="assets/img/juniper-claus.png" alt="">
    </div>
</div>


<?php // <a href="/?logout">Выйти</a> ?>
</body>
</html>