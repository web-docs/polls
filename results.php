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

$users = Poll::stat();
$cnt = 0;
foreach($users as $user) {
    $cnt += $user['cnt'];
}
?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Bucheon University in Tashkent | Результаты голосования</title>
        <link rel="stylesheet" href="assets/css/app.css">


    </head>
    <body>
    <div class="lists">
      <div class="container">
        <div class="lists-wrapper">
          <div class="lists-bg">
            <div class="lists-rel">
              <div class="claus-left">
                <img src="assets/img/raiting-claus-left.png" alt="#">
              </div>
              <div class="lists-abs">
                <div class="bantik">
                  <img src="assets/img/raiting-lents.png" alt="">
                </div>
                <div class="lists-title">
                  <span>Рейтинг голосования</span>
                </div>
              </div>
              <div class="claus-right">
                <img src="assets/img/raiting-claus.png" alt="#">
              </div>
            </div>
          </div>
          <div class="lists-all">
            <div class="list-item">
              <ol>
                <strong>Начальник года</strong>
                <li>
                  <p><small>1.</small>KIM STANISLAV</p>
                  <b class="light-green">+100500</b>
                </li>
                <li>
                  <p><small>2.</small>ABDUQODIROVA ODINA</p>
                  <b>100</b>
                </li>
                <li>
                  <p><small>3.</small>AXMETSHIN MARAT</p>
                  <b>80</b>
                </li>
                <li>
                  <p><small>4.</small>KIM OKSANA</p>
                  <b>70</b>
                </li>
                <li>
                  <p><small>5.</small>KIM OLGA</p>
                  <b>60</b>
                </li>
              </ol>
            </div>
            <div class="list-item">
              <ol>
                <strong>Сотрудник года</strong>
                <li>
                  <p><small>1.</small> KIM STANISLAV</p>
                  <b class="light-green">+100500</b>
                </li>
                <li>
                  <p><small>2.</small>ABDUQODIROVA ODINA</p>
                  <b>100</b>
                </li>
                <li>
                  <p><small>3.</small>AXMETSHIN MARAT</p>
                  <b>80</b>
                </li>
                <li>
                  <p><small>4.</small>KIM OKSANA</p>
                  <b>70</b>
                </li>
                <li>
                  <p><small>5.</small>KIM OLGA</p>
                  <b>60</b>
                </li>
              </ol>
            </div>
            <div class="list-item">
              <ol>
                <strong>Тех персонал года</strong>
                <li>
                  <p><small>1.</small>KIM STANISLAV</p>
                  <b class="light-green">+100500</b>
                </li>
                <li>
                  <p><small>2.</small>ABDUQODIROVA ODINA</p>
                  <b>100</b>
                </li>
                <li>
                  <p><small>3.</small>AXMETSHIN MARAT</p>
                  <b>80</b>
                </li>
                <li>
                  <p><small>4.</small>KIM OKSANA</p>
                  <b>70</b>
                </li>
                <li>
                  <p><small>5.</small>KIM OLGA</p>
                  <b>60</b>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

<div>

    <?php // <a href="/?logout">Выйти</a>
    $limit = 1000;
    $n=1;
    $u = [1=>0,2=>0,3=>0];
    $old_position = '';
    foreach($users as $user){
        if( $user['position_id'] != $old_position ) {
            $old_position = $user['position_id'];
            if($old_position!='') echo '</div>';
            echo '<div id="list_position_'.$user['position_id'].'" class="user-list">';
            $n=1;
        }
        $u[$user['position_id']]++;
        if($u[$user['position_id']]>$limit) continue;

        ?>
        <div class="user-item">
            <div><?=$n . '. ' . $user['fio_passport'] . ' ' . $user['cnt'] ?></div>
            <?php /*<img src="/assets/img/<?=$user['id'] ?>.jpg" width="48px" /><img src="/assets/img/juniper-claus.png" height="32px" /> */ ?>

        </div>
        <?php
        $n++;

    } ?>
</div>


    <?php /*<div style="clear: both">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Голосов</th>
                <th>PID</th>
            </tr>

            <?php
            $n=1;
            foreach($users as $user){ ?>
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

        </table> */ ?>
    </div>
</div>



    </body>
</html>