<?php
include 'setting.php';
if(isset($_GET['id'])){
?>
<html>
	<head>
		<title>Unnamed</title>
		<meta charset="UTF-8">
	</head>
	<body>
<?php
$id = $_GET['id'];
$query = "SELECT `name`, `surname`, `auth` FROM `USERS` WHERE `id` = '$id'";
$result = mysqli_query($CONNECT, $query);
$row = mysqli_fetch_array($result);
if($row['auth'] == 1){
echo '<h1>Добро пожаловать, ' . $row['name'] . ' ' . $row['surname'];
echo '<h1>Вы зарегистрированы в нашей бесполезной социальной сети.</h1>';
echo '<br /><p>Теперь вы можете <a href="login.php">войти</a></p>';
} else {
echo '<p>Ваш профиль не активирован';
}?>
</body>
</html>
<?php
} else {
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
  }?>
