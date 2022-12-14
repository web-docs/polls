<?php

require('init.php');

$error = '';
/*if (Auth::check()) {
    Auth::redirect('present.php');
}*/

if (isset($_POST['register'])) {
    if ($user = Present::add($_POST)) {

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
      <label><input type="text" name="fio_passport" required><?= __('ФИО (по паспорту)') ?></label>
    </div>
    <div>
      <label><input type="text" name="fio" required><?= __('ФИО (кирилица)') ?></label>
    </div>
    <div>
      <label><input type="text" name="department" required><?= __('Отдел') ?></label>
    </div>
    <div>
      <label><input type="text" name="position" required><?= __('Должность') ?></label>
    </div>
    <div>
      <label><?= __('Категория') ?></label>
      <select name="position_id" required>
        <option value="1"><?= __('Начальник') ?></option>
        <option value="2"><?= __('Сотрудник') ?></option>
        <option value="3"><?= __('Тех персонал') ?></option>
      </select>
    </div>
    <div>
      <label><input type="text" name="phone" required><?= __('Телефон (без кода 998)') ?></label>
    </div>

    <div>
      <label><input type="text" name="password" required><?= __('Пароль') ?></label>
    </div>
    <div>
      <label><input type="file" name="photo" required><?= __('Фото') ?></label>
    </div>



    <input type="submit" value="<?= __('Зарегистрировать') ?>">
  </form>
</div>

<?php
include('footer.php')
?>