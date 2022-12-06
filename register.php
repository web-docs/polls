<?php require ('init.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bucheon University in Tashkent | Регистрация</title>
    <link rel="stylesheet" href="assets/css/app.css">
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
    <h1>Регистрация</h1>
    <div class="juniper-img">
        <img src="assets/img/juniper-claus.png" alt="">
    </div>
</div>


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
		<label><input type="text" name="firstname" required>ФИО</label>
	</div>
	<div>
		<label><input type="text" name="department" required>Отдел</label>
	</div>
	<div>
		<label><input type="text" name="position" required>Должность</label>
	</div>
    <div>
        <select name="position_id" required>
            <option value="1">Начальник</option>
            <option value="2">Сотрудник</option>
            <option value="3">Хозчасть</option>
        </select>
    </div>
	<div>
		<label><input type="text" name="phone" required>Телефон</label>
	</div>

    <div>
		<label><input type="text" name="password" required>Пароль</label>
	</div>
	 
    <input type="submit" value="Зарегистрировать">
      
</form>

</body>
</html>