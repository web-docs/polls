<?php

require ('init.php');
/*
if(!Auth::check()){
    Auth::redirect('login.php');
} */
/*
if(isset($_GET['all'])){
    $limit = 1000;
}else{
    $limit = 3;
} */
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




            <?php
            $n=1;
            $u=1;
            $u = [1=>0,2=>0,3=>0];
            $old_position = '';
            foreach($users as $user){
                if( $user['position_id'] != $old_position ) {
                    $old_position = $user['position_id'];
                    if($old_position!='') echo '</div>';
                    echo '<div id="position_'.$user['position_id'].'" class="user-list">';
                }
                $u[$user['position_id']]++;
                if($u[$user['position_id']]>2) continue;

                ?>
                <div class="user-item">
                    <div><?=$n . ' ' . $user['fio_passport'] . ' ' . $user['cnt'] . ' ' . $user['position_id'] ?></div>
                    <td><img src="/assets/img/<?=$user['id'] ?>.jpg" width="48px" /><img src="/assets/img/juniper-claus.png" height="32px" /> </td>

                </div>
                <?php
                $n++;

            } ?>

        </div>


        <table class="table">
            <tr>
                <th>#</th>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Голосов</th>
                <th>type</th>
            </tr>

            <?php
            $n=1;
            $u=1;
            $u = [1=>0,2=>0,3=>0];
            $old_position = '';
            foreach($users as $user){
                if( $user['position_id'] != $old_position ) {
                    $old_position = $user['position_id'];
                }
                $u[$user['position_id']]++;
                if($u[$user['position_id']]>2) continue;

                ?>
                <tr>
                    <td><?=$n ?></td>
                    <td><img src="/assets/img/<?=$user['id'] ?>.jpg" width="48px" /><img src="/assets/img/juniper-claus.png" height="32px" /> </td>
                    <td><?=$user['fio_passport']?></td>
                    <td><?=$user['position'] ?></td>
                    <td><?=$user['cnt']?></td>
                    <td><?=$user['position_id'] ?></td>

                </tr>
                <?php
                $n++;

            } ?>

        </table>
    </div>
</div>



    </body>
</html>