<?php

require('init.php');

//if(!Auth::check()){
//    Auth::redirect('login.php');
//}else{
//    $user = Auth::user();
//    if($user['role']!=User::ROLE_ADMIN){
//        Auth::redirect('login.php');
//    }
//}

$users   = User::getUsersByType(User::POSITION_CHIEF);
$winners = Poll::stat(User::POSITION_CHIEF, 3);

$cnt = 0;
$_users = [];
foreach ($users as $id => $user) {
  if (!file_exists('assets/photo/'.$user['phone'].'.jpg')) {
    //$users[$id]['phone'] = 'user.png';
  } else {
    $users[$id]['phone'] = $users[$id]['phone'].'.jpg';
    $_users[] = $users[$id];
  }
}
$users= $_users;

include('header.php') ?>

<style>
  .lotto-bg {
    position: relative;
  }
</style>


<div class="stat-wrapper">

  <div class="juniper">
    <div class="winner-img">
      <img src="assets/img/winner.png" alt="">
      <h2>Начальник года</h2>
<!--      <h2>Тех персонал года</h2>-->
<!--      <h2>Сотрудник года</h2>-->
    </div>
  </div>

</div>

<div class="winner">
  <div class="container">
    <div class="winner-wrapper">
      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="1">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png?" alt="" id="results_1">
        </div>
        <h3 data-id="<?= $winners[1]['id'] ?>" id="winner_1"></h3>
        <span><?= __('2-е место') ?></span>
      </div>
      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="0">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png" alt="" id="results_0">
        </div>
        <h3 data-id="<?= $winners[0]['id'] ?>" id="winner_0"></h3>
        <span><?= __('1-е место') ?></span>
      </div>
      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="2">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png" alt="" id="results_2">
        </div>
        <h3 data-id="<?= $winners[2]['id'] ?>" id="winner_2"></h3>
        <span><?= __('3-е место') ?></span>
      </div>
    </div>
  </div>
</div>
<div class="winner-mobile">
  <div class="container">
    <div class="winner-wrapper">
      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="1">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png" alt="" id="results_1">
        </div>
        <h3 data-id="<?= $winners[1]['id'] ?>" id="winner_1"></h3>
        <span><?= __('2-е место') ?></span>
      </div>

      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="0">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png" alt="" id="results_0">
        </div>
        <h3 data-id="<?= $winners[0]['id'] ?>" id="winner_0"></h3>
        <span><?= __('1-е место') ?></span>
      </div>
      <div class="winner-user">
        <div class="winner-user__img">
          <div class="lotto-bg">
            <a class="lotto-start__btn generate" data-id="2">
              <?= __('СТАРТ') ?>
            </a>
          </div>
          <img src="assets/photo/user.png" alt="" id="results_2">
        </div>
        <h3 data-id="<?= $winners[2]['id'] ?>" id="winner_2"></h3>
        <span><?= __('3-е место') ?></span>
      </div>
    </div>
  </div>
</div>

<div class="next-awards">
  <a href="/results_2.php" class="lotto-start__btn" target="_blank">Сотрудник года</a>
</div>


<?php
include('footer.php');

?>

<script>

    var users = <?= json_encode($users, JSON_UNESCAPED_UNICODE) ?>;
    var winners = <?= json_encode($winners, JSON_UNESCAPED_UNICODE) ?>;

    var min = 0;
    var max = users.length - 1;

    var path = 'assets/photo/';

    var time = 4000;
    var delay = 100;
    var timerId;
    var image;
    var id;
    var interval;
    var num = 0;
    var oldnum = 0;

    $(document).ready(function () {

        $('#page_title').text('Начальник года')

        $('.generate').click(function () {
            $(this).parent().css('display', 'none');
            id = $(this).data('id');
            image = $('#results_' + id);
            interval = 0;
            timerId = setInterval(timer, delay);
        });
    });

    function timer() {
        time -= delay;
        num = getRandom();
        console.log('random ' + num)

        $(image).attr('src', path + users[num].phone);
        console.log('INNER ' + time + ' ' + delay + ' interval: ' + interval)

        if (time <= 0) {
            interval++;
            if (interval == 1) {
                clearInterval(timerId);
                time = 4000;
                delay = 200;
                timerId = setInterval(timer, delay);
            } else if (interval == 2) {
                clearInterval(timerId);
                time = 4000;
                delay = 300;
                timerId = setInterval(timer, delay);
            } else if (interval == 3) {
                clearInterval(timerId);
                time = 4000;
                delay = 400;
                timerId = setInterval(timer, delay);
            } else if (interval == 4) {
                clearInterval(timerId);
                time = 4000;
                delay = 500;
                timerId = setInterval(timer, delay);
            } else if (interval == 5) {
                clearInterval(timerId);
                time = 4000;
                delay = 600;
                timerId = setInterval(timer, delay);
            } else if (interval == 6) {
                clearInterval(timerId);
                time = 4000;
                delay = 100;
                $(image).attr('src', path + winners[id].phone + '.jpg');
                $('#winner_' + id).text(winners[id].fio_passport);
            }
            console.log("ENTER " + time + ' ' + delay + ' interval: ' + interval)
        }
    }

    function getRandom() {
        res = Math.round(Math.random() * (max - min) + min);
        if(oldnum!=res){
            oldnum=res;
            num = res;
        }else{
            num = getRandom();
        }
        return num;
    }
</script>
