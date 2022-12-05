<?php

require ('init.php');
/*
if(!Auth::check()){
    Auth::redirect('login.php');
} */


$users = Poll::stat();
$cnt = 0;
foreach($users as $user) {
    $cnt += $user['cnt'];
}
?>
    <h3>Всего голосов: <?=$cnt ?></h3>
    <table class="table">
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Голосов</th>
        </tr>

        <?php
        $n=1;
        foreach($users as $user){ ?>
            <tr>
                <th><?=$n ?></th>
                <th><?=$user['firstname']?></th>
                <th><?=$user['lastname']?></th>
                <th><?=$user['cnt']?></th>

            </tr>
        <?php
        $n++;
        } ?>

    </table>

<?php

