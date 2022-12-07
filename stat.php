<?php

require('init.php');
/*
if(!Auth::check()){
    Auth::redirect('login.php');
} */

$users = Poll::stat();
$cnt = 0;
foreach ($users as $user) {
    $cnt += $user['cnt'];
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bucheon University in Tashkent | Results</title>
    <link rel="stylesheet" href="assets/css/app.css">

</head>
<body>


    <div class="stat-wrapper">
        <iframe src="https://gifer.com/embed/6ob" width=480 height=480.000 frameBorder="0" allowFullScreen></iframe><p><a href="https://gifer.com">через GIFER</a></p>
<!--        <div class="happy">-->
<!--            <img src="assets/img/happy.gif" alt="">-->
<!--        </div>-->
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
            <div class="winner-img">
                <img src="assets/img/winner.png" alt="">
            </div>
        </div>

    </div>

        <div class="winner">
            <div class="container">
            <div class="winner-wrapper">
                <div class="winner-user">
                    <div class="winner-user__img">
                        <img src="assets/img/juniper-claus.png" alt="">
                    </div>
                    <h3>Альфредо Припидучи</h3>
                    <span>
                    Сотрудник года
                </span>
                </div>
                <div class="winner-user">
                    <div class="winner-user__img">
                        <img src="assets/img/juniper-claus.png" alt="">
                    </div>
                    <h3>Альфредо Припидучи</h3>
                    <span>
                    Сотрудник года
                </span>
                </div>
                <div class="winner-user">
                    <div class="winner-user__img">
                        <img src="assets/img/juniper-claus.png" alt="">
                    </div>
                    <h3>Альфредо Припидучи</h3>
                    <span>
                    Сотрудник года
                </span>
                </div>
            </div>
        </div>
    </div>


</body>
</html>