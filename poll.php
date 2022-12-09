<?php

// Обработка голоса
require('init.php');

if (!Auth::check()) {
    if (Auth::complete()) {
        Auth::redirect('complete.php');
    }
    Auth::redirect('login.php');
}

if (isset($_POST['poll'])) {
    $users = explode(',', $_POST['user_to']);
    foreach ($users as $user_to) {
        Poll::add($_POST['user_from'], $user_to);
    }
    User::setStatus(Auth::id(), User::STATUS_COMPLETE);
    Auth::redirect('complete.php');
}

$user_from = Auth::id();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Bucheon University in Tashkent | Лучший начальник года</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/media.css">
</head>
<body>

<?php
include('snow.php') ?>
<div class="poll-wrapper">

  <div class="juniper">
    <div class="juniper-img">
      <img src="assets/img/juniper-claus.png" alt="">
    </div>
    <h1 id="position_title">Начальник года</h1>

  </div>
  <form action="poll.php" method="post" id="send">
    <input type="hidden" name="poll" value="1">
    <input type="hidden" name="user_from" value="<?= Auth::id() ?>">
    <input type="hidden" name="user_to" id="user_to" value="0">
  </form>

  <div class="container juniper-container">
    <div class="poll-lists">

        <?php
        $old_position = '';

        $title = [
            1 => 'Начальник года',
            2 => 'Сотрудник года',
            3 => 'Тех персона года',
        ];

        foreach (User::getUsers(User::ROLE_EMPLOYEE) as $user){
        if ($user_from == $user['id']) {
            continue;
        } // пропустить свой id
        if ($user['position_id'] != $old_position) {
        if ($old_position != '') {
            echo '</div>';
        }
        $old_position = $user['position_id'];
        ?>
      <div id="position_<?= $user['position_id'] ?>" data-id="<?= $user['position_id'] ?>" data-title="<?= $title[$user['position_id']] ?>">
          <?php
          } ?>
        <div class="user" data-id="<?= $user['id'] ?>">
          <div class="user-img">
            <img src="assets/img/juniper-claus.png?<?= $user['phone'] ?>.jpg" alt="">
          </div>
          <label>
              <?= $user['fio_passport'] ?>
          </label>
          <a href="#">Голосовать</a>
        </div>
          <?php
          } ?>
      </div>

      <div id="position_4" data-id="4">
      </div>


    </div>
  </div>
  <div class="squirell">
    <img src="assets/img/squirell.png" alt="squirell">
  </div>
</div>


<script src="assets/js/jquery-2.0.3.min.js"></script>
<script>
    $(document).ready(function () {
        var users = [];
        $('.user').click(function () {
            index = $(this).parent().data('id');
            $('#position_' + index).css('display', 'none');
            index++;
            $('#position_' + index).css({'display': 'flex', 'justify-content': 'space-between', 'flex-wrap': 'wrap'});

            users.push($(this).data('id'))
            $('#user_to').val(users);

            if (index == 4) {
                $('form#send').submit();
            }
            $('#position_title').text($('#position_' + index).data('title'))

        });
    })
</script>

</body>
</html>
