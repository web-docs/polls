<?php require ('init.php'); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Polls - login</title>
</head>
<body>

<?php 

$error = '';

if(!Auth::check()){
    if(Auth::complete()){
        Auth::redirect('complete.php');
    }
}else{
    Auth::redirect('poll.php');
}


if(isset($_POST['login'])){
	
	if($user = Auth::login()){

	    if($user['status']==User::STATUS_COMPLETE){
            Auth::redirect('complete.php');
        }
		Auth::redirect('poll.php');
	}else{
		
		$error = "Логин или пароль не верны" ;
		
	}
	
}

if($error){ ?>	
	<div class="alert"><?=$error ?></div>	
<?php }

?>

<form method="post">
	
	<div>
		<label><input type="text" name="login">Телефон</label>
	</div>
	<div>
		<label><input type="password" name="password">Пароль</label>
	</div>
    <input type="submit" value="Войти">
</form>

<a href="register.php">Регистрация</a>

</body>
</html>