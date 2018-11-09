<?php
include 'setting.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	if(isset($_SESSION['id']) && isset($_GET['id'])){
	$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Ошибка соединения');
	$query = "SELECT name, surname, sex FROM `USERS` WHERE id = '" . $_GET['id'] . "'";
	$data = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($data);
	?>
	<a href="index.php">Вернуться в профиль</a>
	<h1>Профиль:</h1>
	<h1><?php echo $row['name'] . ' ' . $row['surname'];?></h1>
	<p>Пол: <?php echo $row['sex']?></p>
	<?php
	mysqli_close($dbc);
	session_start();
	echo '<a href="dialog.php?id=' . $_GET['id'] . '">Написать сообщение</a>';
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}
?>
</body>
</html>

