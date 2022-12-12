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
<?php
include('header.php') ?>
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
                1=>'Начальник года',
                2=>'Сотрудник года',
                3=>'Тех персонал года',
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
            <div id="position_<?= $user['position_id'] ?>" data-id="<?= $user['position_id'] ?>" data-title="<?=$title[$user['position_id']]?>">
                <?php
                } ?>
                <div class="user" data-id="<?= $user['id'] ?>">
                    <div class="user-img">
                        <img src="assets/photo/<?=$user['phone']?>.jpg" alt="">
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


<div class="popup">
    <div>Укажите лучшего по вашему мнению в номинации</div>
    <h1 id="title">Начальник года</h1>
    <button id="next">Продолжить</button>
</div>



<?php
include('footer.php')
?>
<script>
    $(document).ready(function () {
        var users = [];
        var index = 1;

        var nom = [
            '',
            'Начальник года',
            'Сотрудник года',
            'Тех персонал года'
        ];

        $('.popup').css('display','block');
        $('.popup #title').text(nom[index])

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

            $('.popup #title').text(nom[index])
            $('.popup').css('display','block');

        });
        $('#next').click(function(){
            $('.popup').css('display','none');
        })

    })
</script>