<?php
include 'setting.php';
session_start();
if(isset($_SESSION['id']) && isset($_GET['id'])){
$from_id = $_SESSION['id'];
$to_id = $_GET['id'];
$message = $_POST['message'];
	
$query1 = "SELECT `id` FROM `dialog` WHERE `send` = '$from_id' AND `recieve` = '$to_id' OR `send` = '$to_id' AND `recieve` = '$from_id'";

$result = mysqli_query($CONNECT, $query1) or die ('Ошибка запроса к серверу 11');

if (mysqli_num_rows($result) == 0){
	$query2 = "INSERT INTO `dialog` (`status`, `send`, `recieve`) VALUES (0, $from_id, $to_id)";
	$result2 = mysqli_query($CONNECT, $query2) or die ('Ошибка запроса к серверу 2');
	$did = mysqli_insert_id($CONNECT);
} else {
	$row = mysqli_fetch_array($result);
	$did = $row['id'];
	$query2 = "UPDATE `dialog` SET `status` = 0, `send` = '$from_id', `recieve` = '$to_id' WHERE `id` = '$did'";
	$result2 = mysqli_query($CONNECT, $query2) or die ('Ошибка запроса к серверу 3');
}
$query3 = "INSERT INTO `message` (did, user, text, date) VALUES ($did, $from_id, '$message', NOW())";
$reult3 = mysqli_query($CONNECT, $query3) or die ('Ошибка запроса к серверу 4');
mysqli_close($CONNECT);

//$redirect_url = 'http://localhost/project/profile.php?id=' . $to_id;
//header('Location: ' . $redirect_url);

echo 'Кому:' . $to_id . ' От кого:' . $from_id . ' Сообщение:' . $message . ' | ' . '<br />Надеемся, что вашее сообщение отправилось :)';
	} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}
?>
