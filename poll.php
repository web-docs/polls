<?php 
// Обработка голоса
require ('init.php');

if(!Auth::check()){
    if(Auth::complete()){
        Auth::redirect('complete.php');
    }
    Auth::redirect('login.php');
}

if(isset($_POST['poll'])){
    Poll::add($_POST['user_from'],$_POST['user_to']);
    User::setStatus(Auth::id(),User::STATUS_COMPLETE);
    Auth::redirect('complete.php');
}

$user_from = Auth::id();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Голосование</title>

    <style>
        .user{
            padding:10px;
            width: 500px;
            margin:10px 20px;
            border-radius: 5px;
            border: solid 1px #ccc;
            cursor:pointer;
        }
        .user.active{
            background:#ffcc00;
            color:#fff;
            border: solid 1px #cba500;
        }
        </style>

</head>
<body>

<form action="poll.php" method="post">
    <input type="hidden" name="poll" value="1">
    <input type="hidden" name="user_from" value="<?=Auth::id() ?>">
    <input type="hidden" name="user_to" id="user_to" value="0">

    <?php foreach(User::getUsers(User::ROLE_EMPLOYEE) as $user){
        if($user_from==$user['id']) continue; // пропустить свой id
        ?>
        <div class="user" data-id="<?=$user['id'] ?>">
            <label>
                <?=$user['firstname'] .  ' ' . $user['lastname'] ?>
            </label>
        </div>

    <?php } ?>

    <input type="submit" value="Отправить">

</form>

<script src="assets/js/jquery-2.0.3.min.js"></script>
<script>
    $(document).ready(function(){
        $('.user').click(function(){
            $('.user').removeClass('active');
            $(this).addClass('active');
            $('#user_to').val($(this).data('id'));
        });
    })
</script>

</body>
</html>
