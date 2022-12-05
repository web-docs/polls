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
    }
}



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Polls - login</title>
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

<?php include ('alert.php') ?>

<div class="login">
  <div class="container">
    <div class="login-wrapper">
      <div class="login-img">
        <img src="assets/img/login.svg" alt="">
        <form action="" method="POST" class="login-form">
          <div class="form-group">
            <label class="form-label">Телефон</label>
            <div class="login-icon">
              <input type="text" name="login" class="form-control phone-mask" placeholder="Введите номер телефона без знака +">
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

<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/input_mask.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>