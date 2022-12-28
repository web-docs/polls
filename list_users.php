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

$show_all = isset($_GET['all']) ? true : false;
$limit=1000;

$users_count = User::getUsersCount();

$users = Poll::stat();
$list_users = Poll::votes();

foreach ($list_users as $k=> $u){
    if(!file_exists('assets/photo/'.$u['phone'] .'.jpg')){
        $list_users[$k]['phone'] = 'user.png';
    }else{
        $list_users[$k]['phone'] = $list_users[$k]['phone'] . '.jpg';
    }
}

//d($list_users);

//d($users);

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
        .user-photo{
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .user-photo.vote{
            width: 30px;
            height: 30px;
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
                                <div class="text-center text-white"><b>Голосов:</b> <?=ceil($cnts/3) /*?> / <?=$users_count */?></div>
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
                                if($n>$limit && !$show_all) break;
                                ?>
                                <li>
                                    <div>
                                        <p><img src="assets/photo/<?=$user['phone']?>.jpg" class="user-photo" title="<?=$user['id']?>"><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                        <b class="light-green"><?=number_format($user['cnt']*$percent[2],2,'.','') ?>%</b>
                                    </div>
                                    <div>
                                        <?php
                                        $c=0;
                                        foreach($list_users as $u){
                                            if($u['user_to']!=$user['id']) continue;
                                            $c++;
                                            ?>
                                            <img src="assets/photo/<?=$u['phone']?>" title="<?=$u['ufrom'] . ' - ' . $u['uposition'] . ' - ' . $u['user_from']?>" class="user-photo vote">
                                            <?=$u['user_from']?>
                                        <?php } ?>
                                        <div>Всего: <?=$c?></div>
                                    </div>
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
                                if($n>$limit && !$show_all) break;
                                ?>
                                <li>
                                    <div>
                                        <p><img src="assets/photo/<?=$user['phone']?>.jpg" class="user-photo" title="<?=$user['id']?>"><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                    <b class="light-green"><?=number_format($user['cnt']*$percent[1],2,'.','') ?>%</b>
                                    </div>
                                    <div>
                                        <?php
                                        $c=0;
                                        foreach($list_users as $u){
                                            if($u['user_to']!=$user['id']) continue;
                                            $c++;
                                            ?>
                                            <img src="assets/photo/<?=$u['phone']?>" title="<?=$u['ufrom'] . ' - ' . $u['uposition']. ' - ' . $u['user_from']?>" class="user-photo vote">
                                            <?=$u['user_from']?>
                                        <?php } ?>
                                        <div>Всего: <?=$c?></div>
                                    </div>
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
                                if($n>$limit && !$show_all) break;
                                ?>
                                <li>
                                    <div>
                                        <p><img src="assets/photo/<?=$user['phone']?>.jpg" class="user-photo" title="<?=$user['id']?>"><small><?= $n ?></small><?=$user['fio_passport'] ?></p>
                                        <b class="light-green"><?=number_format($user['cnt']*$percent[3],2,'.','') ?>%</b>
                                    </div>
                                    <div>
                                        <?php
                                        $c=0;
                                        foreach($list_users as $u){
                                            if($u['user_to']!=$user['id']) continue;
                                            $c++;
                                            ?>
                                            <img src="assets/photo/<?=$u['phone']?>" title="<?=$u['ufrom'] . ' - ' . $u['uposition']. ' - ' . $u['user_from']?>" class="user-photo vote">
                                            <?=$u['user_from']?>
                                        <?php } ?>
                                        <div>Всего: <?=$c?></div>
                                    </div>
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

?>

<script>
    timerid = setInterval(function(){
        location.reload();
    },1800000);
</script>
