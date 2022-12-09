<?php

require('init.php');
/*
if(!Auth::check()){
    Auth::redirect('login.php');
} */

$users = Poll::stat();
$cnt   = 0;
foreach ($users as $user) {
    $cnt += $user['cnt'];
}
$limit        = 1; // 1 победитель в номинации
$n            = 1;
$u            = [1 => 0, 2 => 0, 3 => 0];
$winner       = [];
$old_position = '';
foreach ($users as $user) {
    if ($user['position_id'] != $old_position) {
        $old_position = $user['position_id'];
        $n            = 1;
    }
    $u[$user['position_id']]++;
    if (!isset($winner[$user['position_id']])) {
        $winner[$user['position_id']] = $user;
    }
    if ($u[$user['position_id']] > $limit) {
        continue;
    }

    $n++;
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
          <img src="assets/img/juniper-claus.png?<?= isset($winner[2]) ? $winner[2]['phone'] : '' ?>.jpg" alt="">
        </div>
        <h3 data-id="<?= $winner[2]['id'] ?>"><?= isset($winner[2]) ? $winner[2]['fio_passport'] : 'Не определен' ?></h3>
        <span>
                    Сотрудник года
                </span>
      </div>
      <div class="winner-user">
        <div class="winner-user__img">
          <img src="assets/img/juniper-claus.png?<?= isset($winner[1]) ? $winner[1]['phone'] : '' ?>.jpg" alt="">
        </div>
        <h3 data-id="<?= $winner[1]['id'] ?>"><?= isset($winner[1]) ? $winner[1]['fio_passport'] : 'Не определен' ?></h3>
        <span>
                    Начальник года
                </span>
      </div>
      <div class="winner-user">
        <div class="winner-user__img">
          <img src="assets/img/juniper-claus.png?<?= isset($winner[3]) ? $winner[3]['phone'] : '' ?>.jpg" alt="">
        </div>
        <h3 data-id="<?= $winner[3]['id'] ?>"><?= isset($winner[3]) ? $winner[3]['fio_passport'] : 'Не определен' ?></h3>
        <span>
                    Тех персона года
                </span>
      </div>
    </div>
  </div>
</div>

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


</body>
</html>