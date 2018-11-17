<?php
include 'setting.php';
session_start();
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
echo '<a href="index.php">Вернуться в профиль</a>';
echo '<h1>Ваши диалоги</h1>';
$query1 = "SELECT * FROM `dialog` WHERE `send`= '$id' OR `recieve` = '$id'";
$result1 = mysqli_query($CONNECT, $query1) or die ('Ошибка запроса к серверу');

while($row1 = mysqli_fetch_array($result1)) {

$did = $row1['id'];
if ($row1['recieve'] == $id){
	$userid = $row1['send'];
}
else if($row1['send'] == $id){ 
	$userid = $row1['recieve'];
}
$query2 = "SELECT * FROM `USERS` WHERE id = '$userid'";

$result2 = mysqli_query($CONNECT, $query2);
if(mysqli_num_rows($result2) == 1){
$row2 = mysqli_fetch_array($result2);
echo '<p><a href="dialogpage.php?did=' . $did . '&id=' . $userid . '">Диалог с пользователем ' . $row2['name'] . ' ' . $row2['surname'] . '</a></p>';
} else {
echo '<p><a href="dialogpage.php?did=' . $did . '&id=DELETED">Диалог с пользователем DELETED</a></p>';
}
}
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}
?>
