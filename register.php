<?php

require('init.php');

$error = '';
if (Auth::check()) {
    Auth::redirect('poll.php');
}

if (isset($_POST['register'])) {
    if ($user = Auth::register()) {
        //Auth::redirect('poll.php');
        //exit;
    } else {
        $error = $_SESSION['error'];
    }
}

$info = @$_SESSION['info'];


?>


    <?php
    include('header.php') ?>
  <style>
    .alert {
      background: #8b1111;
      color: #fff;
      border-radius: 5px;
      width: 500px;
      padding: 15px;
      margin: 10px;
    }
      .alert.success{
          background: #46783a;
          color: #fff;
          border-radius: 5px;
          width: 500px;
          padding: 15px;
          margin: 10px;
      }
  </style>
<div class="juniper">
  <h1>Регистрация</h1>
  <div class="juniper-img">
    <img src="assets/img/juniper-claus.png" alt="">
  </div>
</div>


<?php


if ($error) { ?>
  <div class="alert"><?= $error ?></div>
<?php
}
if ($info) { ?>
    <div class="alert success"><?= $info ?></div>
    <?php
}

?>

<div class="register">
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="register" value="1">
    <div>
      <label><input type="text" name="fio_passport" required>ФИО (по паспорту)</label>
    </div>
    <div>
      <label><input type="text" name="fio" required>ФИО (кирилица)</label>
    </div>
    <div>
      <label><input type="text" name="department" required>Отдел</label>
    </div>
    <div>
      <label><input type="text" name="position" required>Должность</label>
    </div>
    <div>
      <label>Категория</label>
      <select name="position_id" required>
        <option value="1">Начальник</option>
        <option value="2">Сотрудник</option>
        <option value="3">Тех персонал</option>
        <option value="4">Только голосование</option>
      </select>
    </div>
    <div>
      <label><input type="text" name="phone" required>Телефон (без кода 998)</label>
    </div>

    <div>
      <label><input type="text" name="password" required>Пароль</label>
    </div>
    <div>
      <label><input type="file" name="photo" required>Фото</label>
    </div>



    <input type="submit" value="Зарегистрировать">
  </form>
</div>

<?php
include('footer.php')
?>