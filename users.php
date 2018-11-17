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
		<a href="index.php">Вернуться в профиль<a/>
		<hr />
		<h1>Пользователи</h1>
		<hr />
		<?php
			if(isset($_SESSION['id'])){
			$dbc = mysqli_connect(HOST, USER, PASS, DB)
			or die ('Ошибка соединения с сервером');
			$query = "SELECT * FROM `USERS`";
			$result = mysqli_query($dbc, $query)
			or die ('Ошибка запроса к серверу');
			
			while($row = mysqli_fetch_array($result)){
				echo '<p><a href="profile.php?id=' . $row['id'] . '">' . $row['name'] . ' ' . $row['surname'] . '</a></p>';
			}
			mysqli_close($dbc);
		?>
	</body>
</html>
<?php
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}?>
