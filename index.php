<?php
session_start();
include 'setting.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
<?php
if(isset($_SESSION['id'])){
echo '<p><a href="users.php">Пользователи</a> | <a href="messages.php">Мои диалоги</a> | <a href="chat.php">Публичный чат</a> | <a href="logout.php">Выйти</a></p>';
echo '<h1>Ваш профиль:</h1>';
echo '<h1>' . $_SESSION['name'] . ' ' . $_SESSION['surname'] . '</h1>';
echo '<p>Ваш пол:' . $_SESSION['sex'];
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}
/*В диалогах придётся кое-что изменить. Отправка личных сообщений переедет в setting в виде функции, а формы будут обрабатывать сами себя.*/
?>

