<?php

require ('init.php');

if(!Auth::check()){
    Auth::redirect('login.php');
}else{
    $user = Auth::user();
    if($user['role']!=User::ROLE_ADMIN){
        Auth::redirect('login.php');
    }
}


$users_count = User::getUsersCount();

$users = Poll::stat();
$cnt =[];
/*
foreach($users as $user) {
    $cnt += $user['cnt'];
}
$percent = $cnt>0? 100/$cnt : 0; */

foreach($users as $user) {
    $cnt[$user['position_id']] += $user['cnt'];
}

$percent[1] = isset($cnt[1]) && $cnt[1]!=0 ? 100/$cnt[1] :0;
$percent[2] = isset($cnt[2]) && $cnt[2]!=0 ? 100/$cnt[2] :0;
$percent[3] = isset($cnt[3]) && $cnt[3]!=0 ? 100/$cnt[3] :0;

$cnts = $cnt[1]+$cnt[2]+$cnt[3];

include('header.php') ?>

    <style>
        .lists{
            margin-top:200px !important;
        }
    </style>

    <div class="lists">
        <div class="container">
            <div class="lists-wrapper">
                <div class="lists-bg">
                    <div class="lists-rel">
                        <div class="claus-left">
                            <img src="assets/img/raiting-claus-left.png" alt="#">
                        </div>
                        <div class="lists-abs">
                            <div class="bantik">
                                <img src="assets/img/raiting-lents.png" alt="">
                            </div>
                            <div class="lists-title">
                                <span><a href="/list.php"><?= __('Рейтинг') ?> <small><?= __('голосования') ?></small> </a></span>
                                <div class="text-center text-white"><b>Голосов:</b> <?=ceil($cnts/3) ?> / <?=$users_count?></div>
                            </div>
                        </div>
                        <div class="claus-right">
                            <img src="assets/img/raiting-claus.png" alt="#">
                        </div>
                    </div>
                </div>
                <div class="lists-all">
                    <div class="list-item">
                        <ol>
                            <strong><?= __('Сотрудник года') ?></strong>
                            <?php
                            $n=0;
                            foreach($users as $user ){
                                if($user['position_id']!=2) continue;
                                $n++;
                                ?>
                                <li>
                                    <p><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                    <b class="light-green"><?=number_format($user['cnt']*$percent[2],2,'.','') ?>%</b>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                    <div class="list-item">
                        <ol>
                            <strong><?= __('Начальник года') ?></strong>

                            <?php
                            $n=0;
                            foreach($users as $user ){
                                if($user['position_id']!=1) continue;
                                $n++;
                                ?>
                                <li>
                                    <p><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                    <b class="light-green"><?=number_format($user['cnt']*$percent[1],2,'.','') ?>%</b>
                                </li>
                            <?php } ?>

                        </ol>
                    </div>

                    <div class="list-item">
                        <ol>
                            <strong><?= __('Тех персонал года') ?></strong>
                            <?php
                            $n = 0;
                            foreach($users as $user ){
                                if($user['position_id']!=3) continue;
                                $n++;
                                ?>
                                <li>
                                    <p><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                    <b class="light-green"><?=number_format($user['cnt']*$percent[3],2,'.','') ?>%</b>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('footer.php');
