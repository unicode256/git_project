<?php
include 'setting.php';
include 'errors.php';
session_start();
if(isset($_SESSION['id'])){?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
	$(document).ready(function(){
$(window).scrollTop($(document).height());
});
	</script>
</head>
<body>
<hr />
<a href="index.php">Вернуться в профиль</a> | <a href="#back">Вниз</a>
<hr />
<?php

$CONNECT = mysqli_connect(HOST, USER, PASS, DB) or die ('Ошибка соединения с сервером');
$query = "SELECT * FROM `CHAT`";

$result = mysqli_query($CONNECT, $query) or die ('Ошибка запроса к серверу');
if (mysqli_num_rows($result) == 0) echo 'Сообщений пока нет';
else {
while($row = mysqli_fetch_array($result)){
echo '<p><a href="profile.php?id=' . $row['uid'] . '">'. $row['name'] . ' ' . $row['surname'] . '</a><br />' . $row['message'] . '</p><br /><hr />';
}
}
if(!empty($error_chat)){
echo '<p style="color: red;">123' . $error_chat . '</p>';
$error_chat = "";
}
?>
<form action="chatting.php" method="post">
<input type="text" name="message" placeholder="Сообщение..."><br /><input type="submit" value="Отправить">
</form>
<a name="back" href="index.php">Вернуться в профиль</a>
</body>
</html>
<?php
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}?>

