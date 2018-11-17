<?php
include 'setting.php';
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Unnamed</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<?php
		if(isset($_SESSION['id']) && isset($_GET['id'])){
		$to_id = $_GET['id'];
		$dbc = mysqli_connect(HOST, USER, PASS, DB) 
		or die ('Ошибка соединения с сервером');
		$query = "SELECT name, surname FROM `USERS` WHERE id='" . $to_id . "'";
		$data = mysqli_query($dbc, $query) or die ('Ошибка при выполнении запроса');
		$row = mysqli_fetch_array($data);
		echo '<h1>Напишите личное сообщение для пользователя ' . $row['name'] . ' ' . $row['surname'] . '</h1>';
?>
		<form action="sending.php?id=<?php echo $to_id?>" method="post">
			<input type="text" name="message"><br />
			<input type="submit" value="Отправить">
		</form>
<?php
	mysqli_close($dbc);
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}
?>
	</body>
</html>
