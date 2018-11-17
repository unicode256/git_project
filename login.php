<?php
require_once 'setting.php';
session_start();
$style = "";
$error_msg = "";
if(!isset($_SESSION['id'])){
if(isset($_POST['submit'])){
$email = $_POST['email'];
$password = $_POST['password'];
if(!empty($email) && !empty($password)){
	$query0 = "SELECT * FROM `USERS` WHERE email='$email'";
	$result0 = mysqli_query($CONNECT, $query0) or die ('Ошибка при выполнении запроса 0');
	$row0 = mysqli_fetch_array($result0);
	$query = "SELECT * FROM `USERS` WHERE email='$email' AND password='$password'";
	$result = mysqli_query($CONNECT, $query) or die ('Ошибка при выполнении запроса');
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		if($row['auth'] == 0){
		$error_msg = '<p class="error">Ваш профиль не активирован. Пройти активацию можно <a href="submit.php?id=' . $row['id'] . '">здесь</a></p>';
		$style = 'style="padding-bottom: 1px;"';
		} else {
		
		$_SESSION['id'] = $row['id'];
		$_SESSION['sex'] = $row['sex'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['surname'] = $row['surname'];
		$_SESSION['city'] = $row['city'];
		$_SESSION['birth'] = $row['birth'];
		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
		header('Location: ' . $redirect);
		}
	}
	/*if(mysqli_fetch_array($result0) == 1){
		$error_msg = '<p class="error">Неверный пароль</p>';
		$style = 'style="padding-bottom: 1px;"';	
	}*/
	else {
		$error_msg = '<p class="error">Неверный адрес электронной почты или пароль</p>';
		$style = 'style="padding-bottom: 13px;"';
	}
} else {
$error_msg = '<p class="error">Введите адерс электронной почты и пароль</p>';
$style = 'style="padding-bottom: 13px;"';
}
}
}
if(empty($_SESSION['id'])){
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<link href="index1.css" type="text/css" rel="stylesheet">
	</head>
	<body>
	<div class="container" <?php echo $style; ?>>
	<h1>HY TAKOE</h1>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<label>Ваш адрес электронной почты:<br />
			<input class="field" type="text" name="email"></label><br />
			<label>Пароль:<br />
			<input class="field" type="password" name="password"></label><br />
			<input id="submit" name="submit" type="submit" value="Войти"><br />
		</form>
		<a href="registration.php">Регистрация</a>
		<a id="last" href="">Не могу войти</a>
		<?php echo $error_msg; ?>
		</div>
		</body>
	</html><?php
}
else {
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
  }?>

