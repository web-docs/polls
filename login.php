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

if(Auth::check()){
    Auth::redirect('poll.php');
}

if(isset($_POST['login'])){
	
	if($user = Auth::login()){
	
		Auth::redirect('poll.php');

		exit;
	}else{
		
		$error = "login or password incorrect" ;
		
	}
	
}

if($error){ ?>	
	<div class="alert"><?=$error ?></div>	
<?php }

?>

<form method="post">
	
	<div>
		<label><input type="text" name="login">Login</label>
	</div>
	<div>
		<label><input type="password" name="password">Password</label>
	</div>
    <input type="submit" value="Войти">
</form>

</body>
</html>