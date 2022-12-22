<?php

require('init.php');

$error = '';


if (!Auth::check()) {
    if (Auth::complete()) {
        Auth::redirect('complete.php');
    }
} else {
    if (!Auth::complete()) {
        Auth::redirect('poll.php');
    }
}

if (isset($_POST['login'])) {
    if ($user = Auth::login()) {
        if ($user['status'] == User::STATUS_COMPLETE) {
            Auth::redirect('complete.php');
        }
        Auth::redirect('poll.php');
    } else {
        $error = "Логин или пароль не верны";
    }
}


?>

<?php
include('header.php')
?>

<div class="login-wrapper">
  <div class="login">
    <div class="container">
      <div class="login-wrapper">
        <div class="login-img">
          <img src="assets/img/login.svg" class="login-desktop__img" alt="">
            <img src="assets/img/login-mobile.png" class="login-mobile__img" alt="">
          <form method="POST" class="login-form">
            <div class="flags">
              <a href="lang.php?lang=ru">
                <img src="assets/img/ru.png" alt="Russian">
              </a>
              <a href="lang.php?lang=en">
                <img src="assets/img/en.png" alt="English">
              </a>
            </div>
            <div class="form-group">
              <label class="form-label"><?=__('Телефон')?></label>
              <div class="login-icon">
                <input type="text" name="login" class="form-control phone-mask" placeholder="<?=__('Введите номер телефона')?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label"><?=__('Пароль')?></label>
              <div class="password-icon">
                <input type="password" name="password" class="form-control" placeholder="<?=__('Введите пароль')?>" required>
              </div>
            </div>
            <input type="submit" value="<?=__('Войти')?>" class="login-submit">
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<?php
include('footer.php')
?>