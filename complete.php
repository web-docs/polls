<?php

require('init.php');

if (!Auth::check()) {
    Auth::redirect('login.php');
}

$users = Poll::stat();
//d($users);
$cnt   = 0;
foreach ($users as $user) {
  $cnt += $user['cnt'];
}
$percent = 100 / $cnt;
$limit   = 10;

include('header.php') ?>
  <div class="stat-wrapper">

    <div class="juniper">
    </div>
    <h1 class="thanks"><?= __('Спасибо!') ?> <br> <?= __('Ваш голос учтён!') ?></h1>

  </div>
<?php
include('footer.php');