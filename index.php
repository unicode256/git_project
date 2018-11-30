<?php
session_start();
include 'setting.php';
/*В диалогах придётся кое-что изменить. Отправка личных сообщений переедет в setting в виде функции, а формы будут обрабатывать сами себя.*/
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
$current_year = date("Y");
$currnet_month = date("n");
$currnet_day = date("j");
$birth = $_SESSION['birth'];
$birth_year = substr($birth, 0, 4);
$query1 = "SELECT * FROM `images` WHERE sender_id = '$id' AND avatar = 1";
$result1 = mysqli_query($CONNECT, $query1) or die ('Ошибка при выполнении запроса');
$row1 = mysqli_fetch_array($result1);
$img = $row1['image_url'];
$image_style = 'style="background: url(\'images/'  . $img . '\') no-repeat;"';
if (substr($birth, 5, 1) == 0){
	$birth_month = substr($birth, 6, 1);
}
else {
	$birth_month = substr($birth, 5, 2);
}
if (substr($birth, 8, 1) == 0){
	$birth_day = substr($birth, 9, 1);
}
else {
	$birth_day = substr($birth, 8, 2);
}
$age = $current_year - $birth_year;
if($birth_month >= $currnet_month){
	if($birth_day > $currnet_day){
		$age--;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>Мой профиль</title>
        <meta charset="UTF-8">
        <meta http-equiv="Cache-Control" content="private">
		<link href="index2.css" type="text/css" rel="stylesheet">
	</head>
	<body>
	<div class="main_content">
		<div class="leftside"></div>
		<div class="leftside_fixed">
			<h1 id="logo">HY TAKOE</h1
			><a id="one" href="index.php">Мой Профиль</a
			><a id="two" href="messages.php">Мои Сообщения</a
			><a id="three">Мои Контакты</a
			><a id="four">Симпатии</a
			><a id=five>Посетители</a
			><a id="six">Вы Нравитесь</a
			><a id="seven" href="users.php">Люди Рядом</a
			><a id="eight">Знакомства</a>
		</div>
		<div class="content">
			<div class="main_block">
				<div class="ava">	
					<a href="profile_image.php"><div class="picture" <?php if(!empty($image_style)) echo $image_style;?>>
						
					</div></a>
					<a id="edit">Редактировать</a>
				</div>
				<div class="info">
					<div class="info_block">
						<h2><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname'];?></h2>
						<h3 id ="online" class="toleft">Online</h3>
					</div>
					<span class="toleft">Город:</span><span class="toright"><?php echo $_SESSION['city'];?></span><br />
					<span class="toleft">Отн. к курению:</span><span class="toright">Курю время от времени</span><br /> 
					<span class="toleft">Отн к алкоголю:</span><span class="toright">Не пью</span><br />
					<span class="toleft last">Мне <?php echo $age;?>, живу с родителями, 181 см, 66 кг, с голубыми глазами.</span>
				</div>
				<a id="showmore">Показать больше</a>
			</div>
			<div class="photo_block">
				<div class="about_photos">
					<span class="photos">Мои фотографии </span><span class="count">6</span>
					<span class="toalbum">перейти к альбомам</span-->
				</div>
				
				<div class="image"><span class="place_for_photo">Нет фото</span></div>
				<div class="image space"><span class="place_for_photo">Нет фото</span></div>
				<div class="image space"><span class="place_for_photo">Нет фото</span></div>
				<div class="image space"><span class="place_for_photo">Нет фото</span></div>
				<div class="image space"><span class="place_for_photo">Нет фото</span></div>
				<div class="image space"><span class="place_for_photo">Нет фото</span></div>
			</div>
			<form enctype="multipart/form-data>" action="test.php" method="post">
				<input placeholder="Добавить пост..." type="text">
				<input type="submit" value="Добавить">
			</form>
			<div class="post">
					<p class="noposts">Ни одного поста пока нет</p>
			</div>
		</div>
		<!--<div class="rightside"></div>-->
		<div class="rightside_fixed">
			<a id="one1">Настройки</a
			><a id="two2">Помощь</a
			><a id="three3" href="logout.php">Выйти</a>
		</div>
		
	</div>
	<script src="index.js"></script>
	</body>
</html><?php
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}?>

