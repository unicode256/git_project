<?php
include 'setting.php';
session_start();
$error_msg = "";
$no_photo = "";
if(isset($_POST['download_another_img'])){
    if ($_FILES['userfile']['error'] > 0){
        switch ($_FILES['userfile']['error']){
            case 1: $error_msg =  '<p class="error">Размер файла очень большой</p>'; break;
            case 2: $error_msg = '<p class="error">Размер файла очень большой</p>'; break;
            case 3: $error_msg = '<p class="error">Загружена только часть файла</p>'; break;
            case 4: $error_msg = '<p class="error">Не удалось загрузить изображение</p>'; break;
        }
    }
    if ($_FILES['userfile']['type'] != 'image/png'){
        $error_msg = '<p class="error">Файл не является изображением</p>';
    }
$upfile = 'images/' . $_FILES['userfile']['name'];
$img_name = $_FILES['userfile']['name'];
    if($_FILES['userfile']['tmp_name']){
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)){
            $error_msg = '<p class="error">Не удалось загрузить изображение</p>';
        }
    }
    else {
        $error_msg = '<p class="error">Не удалось загрузить изображение</p>';
    }
    $id = $_SESSION['id'];
    $query0 = "UPDATE `images` SET `avatar` = 0 WHERE `sender_id` = '$id'";
    $query = "INSERT INTO `images` (`image_url`, `avatar`, `date`, `likes`, `sender_id`) VALUES ('$img_name', 1, NOW(), 0, $id)";
    $result0 = mysqli_query($CONNECT, $query0) or die ('Ошибка соединения с сервером 0');
    $result = mysqli_query($CONNECT, $query) or die ('Ошибка соединения с сервером');
    $error_msg = '<p class="warning">Ваша фотография изменена</p>';
}?>
<!DOCTYPE html>
<html>
	<head>
		<title>Фотография</title>
        <meta charset="UTF-8">
        <meta http-equiv="Cache-Control" content="private">
        <link href="index2.css" type="text/css" rel="stylesheet">
        <link href="index2_1.css" type="text/css" rel="stylesheet">
	</head>
	<body>
        <div class="main_content">
            <div class="leftside"></div>
            <div class="leftside_fixed">
                <h1 id="logo">HY TAKOE</h1
                ><a id="one" href="index.php">Мой Профиль</a
                ><a id="two">Мои Сообщения</a
                ><a id="three">Мои Контакты</a
                ><a id="four">Симпатии</a
                ><a id=five>Посетители</a
                ><a id="six">Вы Нравитесь</a
                ><a id="seven">Люди Рядом</a
                ><a id="eight">Знакомства</a>
            </div>
            <div class="content">
                <p>Ваша фотография</p>
                <div class="image" <?php if($result0 != FALSE && $result != FALSE) echo 'style="background: url("images/' .  $img_name . '") no-repeat;"'; ?>></div>
                <div class="info">
                    <span class="info_str">Альбом: <span>Аватары</span></span>
                    <span class="info_str">Отправитель: <span>Глеб Андреев</span></span>
                    <span class="info_str">Добавлена: <span>1 августа 2018</span></span>
                    <span class="info_str">Нравится: <span>21</span></span>
                </div>
                <form class="el" action="profile_image.php" method="post" enctype="multipart/form-data"><div id="download" class="el" ><input type="file"><input type="submit" value="Загрузить новую фотографию"></div><input type="submit" name="download_another_img" value="Отправить фотографию"></form>
                <form class="el" action="" method="post"><input type="submit" name="delete" value="Удалить фотографию"></form>
                <a id="original" href="#">Загрузить оригинал</a>
                <?php if(!empty($error_msg)) echo $error_msg;?>
            </div>
            <!--<div class="rightside"></div-->
            <div class="rightside_fixed">
                <a id="one1">Настройки</a
                ><a id="two2">Помощь</a
                ><a id="three3" href="logout.php">Выйти</a>
            </div>
        </div>
        <script src="index.js"></script>
    </body>
</html>