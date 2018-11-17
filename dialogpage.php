<?php
include 'setting.php';
session_start();
//sendMessage(9, 4, 'message');
if(isset($_SESSION['id']) && isset($_GET['did'])){
$id = $_SESSION['id'];
$did = $_GET['did'];
if(!empty($_POST['message'])){
$message = $_POST['message'];
}
//$userid = $_GET['id'];
$error_msg = "";

$query1 = "SELECT * FROM `message` WHERE `did` = '$did'";
$query2 = "SELECT * FROM `dialog` WHERE `id` = '$did'";
$result1 = mysqli_query($CONNECT, $query1) or die ('Ошибка запроса к серверу 1');
$result2 = mysqli_query($CONNECT, $query2) or die ('Ошибка запроса к серверу 2');


$row2 = mysqli_fetch_array($result2);
if ($row2['recieve'] == $id){
	$userid = $row2['send'];
}
else if($row2['send'] == $id){ 
	$userid = $row2['recieve'];
}
$query3 = "SELECT * FROM `USERS` WHERE id = '$userid'";

$result3 = mysqli_query($CONNECT, $query3) or die ('Ошибка запроса к серверу 3');
$row3 = mysqli_fetch_array($result3);

//echo $did . ' ' . $userid . ' ' . $id;
//echo '<br />' . rand(12000, 32000);
echo '<p>Диалог с пользователем ' . $row3['name'] . ' ' . $row3['surname'] . '</p>';
echo '<a href="#back">Вниз</a>';
while($row1 = mysqli_fetch_array($result1)) {
echo '<hr />';
$userid4 = $row1['user'];
$query4 = "SELECT * FROM `USERS` WHERE id = '$userid4'";
$result4 = mysqli_query($CONNECT, $query4) or die ('Ошибка запроса к серверу 4');
$row4 = mysqli_fetch_array($result4);
if ($userid4 == $id) echo '<p>Вы:<br />';
else echo '<p>' . $row4['name'] . ' ' . $row4['surname'] . ':<br />';

echo $row1['text'] . '</p>';
}
if(isset($_POST['submit'])){
if(isset($message)){
//echo $userid . ' ' . $id . ' ' . $message;
$query_1 = "SELECT `id` FROM `dialog` WHERE `send` = '$id' AND `recieve` = '$userid' OR `send` = '$userid' AND `recieve` = '$id'";

$result_1 = mysqli_query($CONNECT, $query_1) or die ('Ошибка запроса к серверу 11');

if (mysqli_num_rows($result_1) == 0){
	$query_2 = "INSERT INTO `dialog` (`status`, `send`, `recieve`) VALUES (0, $id, $userid)";
	$result_2 = mysqli_query($CONNECT, $query_2) or die ('Ошибка запроса к серверу 22');
	$did = mysqli_insert_id($CONNECT);
} else {
	$row = mysqli_fetch_array($result_1);
	$did = $row['id'];
	$query_2 = "UPDATE `dialog` SET `status` = 0, `send` = '$id', `recieve` = '$userid' WHERE `id` = '$did'";
	$result_2 = mysqli_query($CONNECT, $query_2) or die ('Ошибка запроса к серверу 33');
}
$query_3 = "INSERT INTO `message` (did, user, text, date) VALUES ($did, $id, '$message', NOW())";
$reult_3 = mysqli_query($CONNECT, $query_3) or die ('Ошибка запроса к серверу 44');
mysqli_close($CONNECT);
} else {
$error_msg = 'Error, empty message';
}
}
echo '<p style="color: red;">' . $error_msg . '</p>';
?>

<form action="dialogpage.php?did=<?php echo $did?>" method="post">
	<input type="text" name="message"><br />
	<input name="submit" type="submit" value="Отправить"><a href="dialogpage.php?did=<?php echo $did?>">Обновить</a>
</form>
<a name="back" href="messages.php">Вернуться в диалоги</a>
<?php
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}?>

