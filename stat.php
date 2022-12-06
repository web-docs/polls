<?php

require ('init.php');

if(!Auth::check()){
    Auth::redirect('login.php');
}

if(isset($_GET['all'])){
    $limit = 1000;
}else{
    $limit = 3;
}

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

        <h1>Результаты голосования</h1>

        <div class="juniper-img">
            <img src="assets/img/juniper-claus.png" alt="">
        </div>
    </div>

<div>
    <div>
        <h1>Всего голосов: <?=$cnt ?></h1>
    </div>
    <div style="clear: both">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Голосов</th>
            </tr>

            <?php
            $n=1;
            foreach($users as $user){ ?>
                <tr>
                    <td><?=$n ?></td>
                    <td><img src="/assets/img/<?=$user['id'] ?>.jpg" /><img src="/assets/img/juniper-claus.png" height="32px" /> </td>
                    <td><?=$user['fio_passport']?></td>
                    <td><?=$user['position'] . ' ' . $user['position_id']?></td>
                    <td><?=$user['cnt']?></td>
                </tr>
                <?php
                $n++;
            } ?>

        </table>
    </div>
</div>



    </body>
</html>