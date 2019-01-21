<?php
include 'setting.php';
if(isset($_GET['id'])){
$error_msg = "";
$id = $_GET['id'];
$query0 = "SELECT * FROM `USERS` WHERE `id` = '$id'";
$result0 = mysqli_query($CONNECT, $query0);
$row0 = mysqli_fetch_array($result0);
mail($row0['email'], "Submition code", $row0['code']);
if(isset($_POST['submit'])){
if($_POST['code']){

$code = $_POST['code'];
$query = "SELECT `code` FROM `USERS` WHERE `id` = '$id'";
$result = mysqli_query($CONNECT, $query);
$row = mysqli_fetch_array($result);
if ($code == $row['code']){
$query2 = "UPDATE `USERS` SET `auth` = 1 WHERE `id` = '$id'";
mysqli_query($CONNECT, $query2);
$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/submition.php?id=' . $id;
header('Location: ' . $redirect);
} else {
$error_msg = 'Неверный код подтверждения';
}
}
else {
$error_msg = 'Вы не ввели код подтверждения';
}
}
?>
<html>
	<head>
		<title>Unnamed</title>
		<meta charset="UTF-8">
	</head>
	<body>
	<p>Вам на почту должно прийти сообщение с кодом подтверждения</p>
<?php echo '<p style="color: red;">' . $error_msg . '</p>';?>
<form method="post" action="submit.php?id=<?php echo $id; ?>">
	Введите код подтверждения: <input type="text" name="code"><input name="submit" type="submit" value="Подтвердить">
	</form>
</body>
</html>
<?php
} else {
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
  }?>