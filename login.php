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
</head>
<style>
  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
  body {
    min-height: 100vh;
    height: 100%;
    background-color: #8CCEFE;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    position: relative;
  }
  .container {
    max-width: 1480px;
    width: 100%;
    padding: 0 15px;
    margin: 0 auto;
  }
  .login-img {
    width: 100%;
    height: 100%;
    position: relative;
  }
  .login-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }
  .login-form {
    width: 410px;
    height: 230px;
    border: 1px solid;
    position: absolute;
    left: 32%;
    top: 25%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .snowing {
    position: absolute;
    filter: blur(1px);
    /*z-index: 1;*/
    width: 100%;
    height: 100%;
  }

  .snowing .small {
    position: absolute;
    width: 6px;
    height: 6px;
    background: #fff;
    border-radius: 50%;
    -webkit-animation-name: snow-fall, snow-shake;
    animation-name: snow-fall, snow-shake;
    -webkit-animation-duration: 12s, 4s;
    animation-duration: 12s, 4s;
    -webkit-animation-timing-function: linear, ease-in-out;
    animation-timing-function: linear, ease-in-out;
    -webkit-animation-iteration-count: infinite, infinite;
    animation-iteration-count: infinite, infinite;
    top: -100%;
  }
  .small-snow-left .small:nth-child(1) {
    left: 210px;
    top: -40px;
    -webkit-animation-delay: 9s, 0.3s;
    animation-delay: 9s, 0.3s;
  }
  .small-snow-left .small:nth-child(2) {
    left: 400px;
    top: -50px;
    -webkit-animation-delay: 6s, 0.3s;
    animation-delay: 6s, 0.3s;
  }
  .small-snow-left .small:nth-child(3) {
    left: 720px;
    top: -130px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .small-snow-left .small:nth-child(4) {
    left: 140px;
    -webkit-animation-delay: 10s, 0.3s;
    animation-delay: 10s, 0.3s;
  }
  .small-snow-left .small:nth-child(5) {
    left: 500px;
    -webkit-animation-delay: 7s, 0.2s;
    animation-delay: 7s, 0.2s;
  }
  .small-snow-left .small:nth-child(6) {
    left: 150px;
    top: -30px;
    -webkit-animation-delay: 5.2s, 0.3s;
    animation-delay: 5.2s, 0.3s;
  }
  .small-snow-left .small:nth-child(7) {
    left: 200px;
    top: -20px;
    -webkit-animation-delay: 3.4s, 0.3s;
    animation-delay: 3.4s, 0.3s;
  }
  .small-snow-left .small:nth-child(8) {
    left: 70px;
    top: -330px;
    -webkit-animation-delay: 6.6s, 0.3s;
    animation-delay: 6.6s, 0.3s;
  }
  .small-snow-left .small:nth-child(9) {
    left: 380px;
    top: -90px;
    -webkit-animation-delay: 5.6s, 0.3s;
    animation-delay: 5.6s, 0.3s;
  }
  .small-snow-left .small:nth-child(10) {
    left: 130px;
    -webkit-animation-delay: 11s, 0.2s;
    animation-delay: 11s, 0.2s;
  }
  .small-snow-left .small:nth-child(11) {
    left: 20px;
    -webkit-animation-delay: 10.5s, 0.3s;
    animation-delay: 10.5s, 0.3s;
  }
  .small-snow-left .small:nth-child(12) {
    left: 620px;
    top: -40px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .small-snow-left .small:nth-child(13) {
    left: 400px;
    top: -180px;
    -webkit-animation-delay: 3.7s, 3s;
    animation-delay: 3.7s, 3s;
  }
  .small-snow-left .small:nth-child(14) {
    left: 500px;
    top: -370px;
    -webkit-animation-delay: 6s, 0.3s;
    animation-delay: 6s, 0.3s;
  }
  .small-snow-left .small:nth-child(15) {
    left: 660px;
    top: -20px;
    -webkit-animation-delay: 9s, 0.3s;
    animation-delay: 9s, 0.3s;
  }
  .small-snow-left .small:nth-child(16) {
    left: 610px;
    top: -80px;
    -webkit-animation-delay: 7.3s, 0.3s;
    animation-delay: 7.3s, 0.3s;
  }
  .small-snow-left .small:nth-child(17) {
    left: 20px;
    top: -210px;
    -webkit-animation-delay: 6.8s, 2s;
    animation-delay: 6.8s, 2s;
  }
  .small-snow-left .small:nth-child(18) {
    left: 670px;
    top: -200px;
    -webkit-animation-delay: 6.5s, 0.6s;
    animation-delay: 6.5s, 0.6s;
  }
  .small-snow-left .small:nth-child(19) {
    left: 210px;
    top: -120px;
    -webkit-animation-delay: 4s, 0.3s;
    animation-delay: 4s, 0.3s;
  }
  .small-snow-left .small:nth-child(20) {
    left: 20px;
    top: -110px;
    -webkit-animation-delay: -1.1s, -0.1s;
    animation-delay: -1.1s, -0.1s;
  }

  .small-snow-right .small:nth-child(1) {
    right: 210px;
    top: -40px;
    -webkit-animation-delay: 9s, 0.3s;
    animation-delay: 9s, 0.3s;
  }
  .small-snow-right .small:nth-child(2) {
    right: 400px;
    top: -50px;
    -webkit-animation-delay: 6s, 0.3s;
    animation-delay: 6s, 0.3s;
  }
  .small-snow-right .small:nth-child(3) {
    right: 720px;
    top: -130px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .small-snow-right .small:nth-child(4) {
    right: 140px;
    -webkit-animation-delay: 10s, 0.3s;
    animation-delay: 10s, 0.3s;
  }
  .small-snow-right .small:nth-child(5) {
    right: 500px;
    -webkit-animation-delay: 7s, 0.2s;
    animation-delay: 7s, 0.2s;
  }
  .small-snow-right .small:nth-child(6) {
    right: 150px;
    top: -30px;
    -webkit-animation-delay: 5.2s, 0.3s;
    animation-delay: 5.2s, 0.3s;
  }
  .small-snow-right .small:nth-child(7) {
    right: 200px;
    top: -20px;
    -webkit-animation-delay: 3.4s, 0.3s;
    animation-delay: 3.4s, 0.3s;
  }
  .small-snow-right .small:nth-child(8) {
    right: 70px;
    top: -330px;
    -webkit-animation-delay: 6.6s, 0.3s;
    animation-delay: 6.6s, 0.3s;
  }
  .small-snow-right .small:nth-child(9) {
    right: 380px;
    top: -90px;
    -webkit-animation-delay: 5.6s, 0.3s;
    animation-delay: 5.6s, 0.3s;
  }
  .small-snow-right .small:nth-child(10) {
    right: 130px;
    -webkit-animation-delay: 11s, 0.2s;
    animation-delay: 11s, 0.2s;
  }
  .small-snow-right .small:nth-child(11) {
    right: 20px;
    -webkit-animation-delay: 10.5s, 0.3s;
    animation-delay: 10.5s, 0.3s;
  }
  .small-snow-right .small:nth-child(12) {
    right: 620px;
    top: -40px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .small-snow-right .small:nth-child(13) {
    right: 400px;
    top: -180px;
    -webkit-animation-delay: 3.7s, 3s;
    animation-delay: 3.7s, 3s;
  }
  .small-snow-right .small:nth-child(14) {
    right: 500px;
    top: -370px;
    -webkit-animation-delay: 6s, 0.3s;
    animation-delay: 6s, 0.3s;
  }
  .small-snow-right .small:nth-child(15) {
    right: 660px;
    top: -20px;
    -webkit-animation-delay: 9s, 0.3s;
    animation-delay: 9s, 0.3s;
  }
  .small-snow-right .small:nth-child(16) {
    right: 610px;
    top: -80px;
    -webkit-animation-delay: 7.3s, 0.3s;
    animation-delay: 7.3s, 0.3s;
  }
  .small-snow-right .small:nth-child(17) {
    right: 20px;
    top: -210px;
    -webkit-animation-delay: 6.8s, 2s;
    animation-delay: 6.8s, 2s;
  }
  .small-snow-right .small:nth-child(18) {
    right: 670px;
    top: -200px;
    -webkit-animation-delay: 6.5s, 0.6s;
    animation-delay: 6.5s, 0.6s;
  }
  .small-snow-right .small:nth-child(19) {
    right: 210px;
    top: -120px;
    -webkit-animation-delay: 4s, 0.3s;
    animation-delay: 4s, 0.3s;
  }
  .small-snow-right .small:nth-child(20) {
    right: 20px;
    top: -110px;
    -webkit-animation-delay: -1.1s, -0.1s;
    animation-delay: -1.1s, -0.1s;
  }
  .snowing .medium {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
    -webkit-animation-name: snow-fall, snow-shake;
    animation-name: snow-fall, snow-shake;
    -webkit-animation-duration: 12s, 4s;
    animation-duration: 12s, 4s;
    -webkit-animation-timing-function: linear, ease-in-out;
    animation-timing-function: linear, ease-in-out;
    -webkit-animation-iteration-count: infinite, infinite;
    animation-iteration-count: infinite, infinite;
    top: -100%;
  }
  .medium-snow-left .medium:nth-child(1) {
    left: 300px;
    top: -420px;
    -webkit-animation-delay: 3.4s, 1s;
    animation-delay: 3.4s, 1s;
  }
  .medium-snow-left .medium:nth-child(2) {
    left: 530px;
    -webkit-animation-delay: 0.2s, 0.1s;
    animation-delay: 0.2s, 0.1s;
  }
  .medium-snow-left .medium:nth-child(3) {
    left: 340px;
    top: -110px;
    -webkit-animation-delay: 6s, 2s;
    animation-delay: 6s, 2s;
  }
  .medium-snow-left .medium:nth-child(4) {
    left: 250px;
    top: -390px;
    -webkit-animation-delay: 3.4s, 3s;
    animation-delay: 3.4s, 3s;
  }
  .medium-snow-left .medium:nth-child(5) {
    left: 400px;
    top: -150px;
    -webkit-animation-delay: 8.4s, 0.3s;
    animation-delay: 8.4s, 0.3s;
  }
  .medium-snow-left .medium:nth-child(6) {
    left: 720px;
    top: -240px;
    -webkit-animation-delay: 7.7s, 1s;
    animation-delay: 7.7s, 1s;
  }
  .medium-snow-left .medium:nth-child(7) {
    left: 350px;
    top: -180px;
    -webkit-animation-delay: 6s, 0.5s;
    animation-delay: 6s, 0.5s;
  }
  .medium-snow-left .medium:nth-child(8) {
    left: 560px;
    -webkit-animation-delay: 1s, 0.5s;
    animation-delay: 1s, 0.5s;
  }
  .medium-snow-left .medium:nth-child(9) {
    left: 10px;
    top: -310px;
    -webkit-animation-delay: 8.2s, 0.5s;
    animation-delay: 8.2s, 0.5s;
  }
  .medium-snow-left .medium:nth-child(10) {
    left: 40px;
    top: -220px;
    -webkit-animation-delay: 3s, 1s;
    animation-delay: 3s, 1s;
  }
  .medium-snow-left .medium:nth-child(11) {
    left: 220px;
    top: -530px;
    -webkit-animation-delay: 0.6s, 3s;
    animation-delay: 0.6s, 3s;
  }
  .medium-snow-left .medium:nth-child(12) {
    left: 630px;
    top: -10px;
    -webkit-animation-delay: 9.4s, 2s;
    animation-delay: 9.4s, 2s;
  }
  .medium-snow-left .medium:nth-child(13) {
    left: 420px;
    top: -60px;
    -webkit-animation-delay: 8s, 3s;
    animation-delay: 8s, 3s;
  }
  .medium-snow-left .medium:nth-child(14) {
    left: 580px;
    -webkit-animation-delay: 2s, 0.3s;
    animation-delay: 2s, 0.3s;
  }
  .medium-snow-left .medium:nth-child(15) {
    left: 420px;
    top: -180px;
    -webkit-animation-delay: 7s, 1s;
    animation-delay: 7s, 1s;
  }
  .medium-snow-left .medium:nth-child(16) {
    left: 360px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .medium-snow-left .medium:nth-child(17) {
    left: 90px;
    top: -190px;
    -webkit-animation-delay: 4.5s, 1s;
    animation-delay: 4.5s, 1s;
  }
  .medium-snow-left .medium:nth-child(18) {
    left: 130px;
    top: -330px;
    -webkit-animation-delay: 8.2s, 1s;
    animation-delay: 8.2s, 1s;
  }
  .medium-snow-left .medium:nth-child(19) {
    left: 150px;
    top: -490px;
    -webkit-animation-delay: 6.5s, 0.1s;
    animation-delay: 6.5s, 0.1s;
  }
  .medium-snow-left .medium:nth-child(20) {
    left: 640px;
    top: -270px;
    -webkit-animation-delay: 10s, 1.5s;
    animation-delay: 10s, 1.5s;
  }
  .medium-snow-right .medium:nth-child(1) {
    right: 300px;
    top: -420px;
    -webkit-animation-delay: 3.4s, 1s;
    animation-delay: 3.4s, 1s;
  }
  .medium-snow-right .medium:nth-child(2) {
    right: 530px;
    -webkit-animation-delay: 0.2s, 0.1s;
    animation-delay: 0.2s, 0.1s;
  }
  .medium-snow-right .medium:nth-child(3) {
    right: 340px;
    top: -110px;
    -webkit-animation-delay: 6s, 2s;
    animation-delay: 6s, 2s;
  }
  .medium-snow-right .medium:nth-child(4) {
    right: 250px;
    top: -390px;
    -webkit-animation-delay: 3.4s, 3s;
    animation-delay: 3.4s, 3s;
  }
  .medium-snow-right .medium:nth-child(5) {
    right: 400px;
    top: -150px;
    -webkit-animation-delay: 8.4s, 0.3s;
    animation-delay: 8.4s, 0.3s;
  }
  .medium-snow-right .medium:nth-child(6) {
    right: 720px;
    top: -240px;
    -webkit-animation-delay: 7.7s, 1s;
    animation-delay: 7.7s, 1s;
  }
  .medium-snow-right .medium:nth-child(7) {
    right: 350px;
    top: -180px;
    -webkit-animation-delay: 6s, 0.5s;
    animation-delay: 6s, 0.5s;
  }
  .medium-snow-right .medium:nth-child(8) {
    right: 560px;
    -webkit-animation-delay: 1s, 0.5s;
    animation-delay: 1s, 0.5s;
  }
  .medium-snow-right .medium:nth-child(9) {
    right: 10px;
    top: -310px;
    -webkit-animation-delay: 8.2s, 0.5s;
    animation-delay: 8.2s, 0.5s;
  }
  .medium-snow-right .medium:nth-child(10) {
    right: 40px;
    top: -220px;
    -webkit-animation-delay: 3s, 1s;
    animation-delay: 3s, 1s;
  }
  .medium-snow-right .medium:nth-child(11) {
    right: 220px;
    top: -530px;
    -webkit-animation-delay: 0.6s, 3s;
    animation-delay: 0.6s, 3s;
  }
  .medium-snow-right .medium:nth-child(12) {
    right: 630px;
    top: -10px;
    -webkit-animation-delay: 9.4s, 2s;
    animation-delay: 9.4s, 2s;
  }
  .medium-snow-right .medium:nth-child(13) {
    right: 420px;
    top: -60px;
    -webkit-animation-delay: 8s, 3s;
    animation-delay: 8s, 3s;
  }
  .medium-snow-right .medium:nth-child(14) {
    right: 580px;
    -webkit-animation-delay: 2s, 0.3s;
    animation-delay: 2s, 0.3s;
  }
  .medium-snow-right .medium:nth-child(15) {
    right: 420px;
    top: -180px;
    -webkit-animation-delay: 7s, 1s;
    animation-delay: 7s, 1s;
  }
  .medium-snow-right .medium:nth-child(16) {
    right: 360px;
    -webkit-animation-delay: 8s, 0.3s;
    animation-delay: 8s, 0.3s;
  }
  .medium-snow-right .medium:nth-child(17) {
    right: 90px;
    top: -190px;
    -webkit-animation-delay: 4.5s, 1s;
    animation-delay: 4.5s, 1s;
  }
  .medium-snow-right .medium:nth-child(18) {
    right: 130px;
    top: -330px;
    -webkit-animation-delay: 8.2s, 1s;
    animation-delay: 8.2s, 1s;
  }
  .medium-snow-right .medium:nth-child(19) {
    right: 150px;
    top: -490px;
    -webkit-animation-delay: 6.5s, 0.1s;
    animation-delay: 6.5s, 0.1s;
  }
  .medium-snow-right .medium:nth-child(20) {
    right: 640px;
    top: -270px;
    -webkit-animation-delay: 10s, 1.5s;
    animation-delay: 10s, 1.5s;
  }

  @-webkit-keyframes snow-fall {
    0% {
      top: -10%;
    }
    100% {
      top: 100%;
    }
  }

  @keyframes snow-fall {
    0% {
      top: -10%;
    }
    100% {
      top: 100%;
    }
  }
  @-webkit-keyframes snow-shake {
    0% {
      transform: translateX(0px);
    }
    50% {
      transform: translateX(60px);
    }
    100% {
      transform: translateX(0px);
    }
  }
  @keyframes snow-shake {
    0% {
      transform: translateX(0px);
    }
    50% {
      transform: translateX(60px);
    }
    100% {
      transform: translateX(0px);
    }
  }
</style>
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
            <input type="text" name="login" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control">
          </div>
          <input type="submit" value="Войти">
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>