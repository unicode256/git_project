<?php
session_start();
include 'setting.php';
include 'errors.php';
$msg = $_POST['message'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$id = $_SESSION['id'];
if(!empty($msg)){

$CONNECT = mysqli_connect(HOST, USER, PASS, DB) or die ('Ошибка соединения');

$query = "INSERT INTO `CHAT` (uid, name, surname, message, date) VALUES ($id, '$name', '$surname', '$msg', NOW())";

mysqli_query($CONNECT, $query);
$error_chat = 'Success';
$redirect_url = 'http://localhost/project/chat.php';
header('Location: ' . $redirect_url);
} else {

$redirect_url = 'http://localhost/project/chat.php';
header('Location: ' . $redirect_url);
}
?>
