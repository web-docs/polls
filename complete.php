<?php

require('init.php');

/*if (!Auth::check()) {
    Auth::redirect('login.php');
}*/


$users = Poll::stat();
$cnt   = 0;
foreach ($users as $user) {
  $cnt += $user['cnt'];
}
$percent = 100 / $cnt;
$limit   = 10;

?>

<?php
include('header.php') ?>
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
              <strong>Сотрудник года</strong>
              <?php
              $n = 0;
              foreach ($users as $user) {
                if ($user['position_id'] != 2) {
                  continue;
                }
                $n++;
                if ($n > $limit) {
                  continue;
                }
                ?>
                <li>
                  <p><small><?= $n ?></small><?= $user['fio_passport'] ?></p>
                  <b class="light-green"><?= number_format($user['cnt'] * $percent, 2, '.', '') ?>%</b>
                </li>
              <?php
              } ?>
            </ol>
          </div>
          <div class="list-item">
            <ol>
              <strong>Начальник года</strong>

              <?php
              $n = 0;
              foreach ($users as $user) {
                if ($user['position_id'] != 1) {
                  continue;
                }
                $n++;
                if ($n > $limit) {
                  continue;
                }
                ?>
                <li>
                  <p><small><?= $n ?></small><?= $user['fio_passport'] ?></p>
                  <b class="light-green"><?= number_format($user['cnt'] * $percent, 2, '.', '') ?>%</b>
                </li>
              <?php
              } ?>

            </ol>
          </div>

          <div class="list-item">
            <ol>
              <strong>Тех персонал года</strong>
              <?php
              $n = 0;
              foreach ($users as $user) {
                if ($user['position_id'] != 3) {
                  continue;
                }
                $n++;
                if ($n > $limit) {
                  continue;
                }
                ?>
                <li>
                  <p><small><?= $n ?></small><?= $user['fio_passport'] ?></p>
                  <b class="light-green"><?= number_format($user['cnt'] * $percent, 2, '.', '') ?>%</b>
                </li>
              <?php
              } ?>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php
include('footer.php')
?>