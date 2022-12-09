<?php

require('init.php');

$error = '';

if (!Auth::check()) {
    if (Auth::complete()) {
        Auth::redirect('complete.php');
    }
} else {
    Auth::redirect('poll.php');
}

if (isset($_POST['login'])) {
    if ($user = Auth::login()) {
        if ($user['status'] == User::STATUS_COMPLETE) {
            Auth::redirect('complete.php');
        }
        Auth::redirect('poll.php');
    } else {
        $error = "Логин или пароль не верны";
        d($_POST, 1);
    }
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Polls - login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/media.css">
</head>
<body>
<?php
include('snow.php') ?>

<div class="login-wrapper">
  <div class="login">
    <div class="container">
      <div class="login-wrapper">
        <div class="login-img">
          <img src="assets/img/login.svg" class="login-desktop__img" alt="">
            <img src="assets/img/login-mobile.png" class="login-mobile__img" alt="">
          <form action="" method="POST" class="login-form">
            <div class="form-group">
              <label class="form-label">Телефон</label>
              <div class="login-icon">
                <input type="text" name="login" class="form-control phone-mask" placeholder="Введите номер телефона">
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Пароль</label>
              <div class="password-icon">
                <input type="password" name="password" class="form-control" placeholder="Введите пароль">
              </div>
            </div>
            <input type="submit" value="Войти" class="login-submit">
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="assets/libs/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/input_mask.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>