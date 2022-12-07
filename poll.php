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
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>


<div class="poll-wrapper">
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
    <div class="juniper">
        <h1>Номинация</h1>
        <div class="juniper-img">
            <img src="assets/img/juniper-claus.png" alt="">
        </div>
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
            <div id="position_<?= $user['position_id'] ?>" data-id="<?= $user['position_id'] ?>">
                <?php
                } ?>
                <div class="user" data-id="<?= $user['id'] ?>">
                    <div class="user-img">
                        <img src="assets/img/juniper-claus.png" alt="">
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
            $('#position_' + index).css({'display':'flex','justify-content':'space-between'});

            users.push($(this).data('id'))
            $('#user_to').val(users);

            if (index == 4) {
                $('form#send').submit();
            }
        });
    })
</script>

</body>
</html>
