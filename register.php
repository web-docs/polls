<?php require ('init.php'); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Polls - register</title>
    <style>
        .alert{
            background: #8b1111;
            color:#fff;
            border-radius: 5px;
            width: 500px;
            padding: 15px;
            margin: 10px;
        }
    </style>
</head>
<body>

<?php 

$error = '';

if(Auth::check()){
    Auth::redirect('poll.php');
}

if(isset($_POST['register'])){
	
	if($user = Auth::register()){
		Auth::redirect('poll.php');
		exit;
	}else{
		$error = $_SESSION['error'] ;
	}
	
}

if($error){ ?>	
	<div class="alert"><?=$error ?></div>	
<?php }

?>

<form method="post">
	<input type="hidden" name="register" value="1">
	<div>
		<label><input type="text" name="firstname">Имя</label>
	</div>
	<div>
		<label><input type="text" name="lastname">Фамилия</label>
	</div>
	<div>
		<label><input type="text" name="phone">Телефон</label>
	</div>
    <div>
        <label>Отдел (укажите свой отдел)</label>
        <select name="department_id">
            <?php foreach (Department::getList() as $department){ ?>
                <option value="<?=$department['id'] ?>"><?=$department['title'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div>
		<label><input type="password" name="password">Пароль</label>
	</div>
	 
    <input type="submit" value="Зарегистрировать">
      
</form>

</body>
</html>