<?php
include 'setting.php';
session_start();
if(isset($_SESSION['id'])){
$error_msg = "";
$photo = "";
$no_photo = "";
$section = $_POST['section'];
$id = $_SESSION['id'];
    $query1 = "SELECT * FROM `images` WHERE `avatar` = 1 AND `sender_id` = '$id'";
    $result1 = mysqli_query($CONNECT, $query1) or die ('Ошибка соединения с сервером 000');
    //if(mysqli_num_rows($result1) == 1){
        $row1 = mysqli_fetch_array($result1);
        //if($row1['is_croped_image'] == 1){
            $photo1 = 'style="background: url(\'images/croped_images/croped_' . $row1['image_url'] . '\') no-repeat;"';
        //}
        /*if($row1['is_croped_image'] == 0){
            $picture = 'images/' . $row1['image_url'];
            $ext = pathinfo($picture, PATHINFO_EXTENSION);
            if($ext == 'JPEG' || $ext == 'JPG'){
                $src_img = imagecreatefromjpeg($picture);
            }
            if($ext == 'png'){
                $src_img = imagecreatefrompng($picture);
            }
            $dest_img = imagecreatetruecolor(500, 500);
            $width = imagesx($src_img);
            $height = imagesy($src_img);
            $srcx = "";
            $srcy = "";
            if($section == 1){
                $srcx = 0;
                $srcy = 0;
            }
            if($section == 3){
                $srcx = $width-500;
                $srcy = 0;
            }
            imagecopyresized($dest_img ,$src_img , 0, 0, $srcx, $srcy, $width, $height, $width, $height);
            $save_path = 'images/croped_images/croped_' . $row1['image_url'];
            if($ext == 'png'){
                imagepng($dest_img, $save_path);
            }
            if($ext == 'JPEG' || $ext == 'JPG' || $ext == 'jpg' || $ext == 'jpeg'){
                imagejpeg($dest_img, $save_path);
            }
            $photo1 = 'style="background: url(\'images/croped_images/croped_' . $row1['image_url'] . '\') no-repeat;"';
            $query0 = "UPDATE `images` SET `is_croped_image` = 1 WHERE `sender_id` = '$id' AND `avatar` = 1";
            mysqli_query($CONNECT, $query0) or die ('Ошибка соединения с сервером 777');
        }*/
    //}
    //else {
    //    $error_msg =  '<p class="error">У Вас нет фотографии</p>';
    //}
    if(isset($_POST['download_another_img'])){
    if ($_FILES['userfile']['error'] > 0){
        switch ($_FILES['userfile']['error']){
            case 1: $error_msg =  '<p class="error">Размер файла очень большой</p>'; break;
            case 2: $error_msg = '<p class="error">Размер файла очень большой</p>'; break;
            case 3: $error_msg = '<p class="error">Загружена только часть файла</p>'; break;
            case 4: $error_msg = '<p class="error">Не удалось загрузить изображение</p>'; break;
        }

    }
    if ($_FILES['userfile']['type'] != 'image/png' || $_FILES['userfile']['type'] != 'image/jpg'){
        $error_msg = '<p class="error">Файл не является изображением</p>';
    }
    $upfile = 'images/' . $_FILES['userfile']['name'];
    $img_name = $_FILES['userfile']['name'];
    if($_FILES['userfile']['tmp_name']){
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)){
            $error_msg = '<p class="error">Не удалось загрузить изображение</p>';
        }
        else {
            $query0 = "UPDATE `images` SET `avatar` = 0 WHERE `sender_id` = '$id'";
            $query = "INSERT INTO `images` (image_url, is_croped_image, avatar, date, likes, sender_id) VALUES ('$img_name', 0, 1, NOW(), 0, $id)";
            $result0 = mysqli_query($CONNECT, $query0) or die ('Ошибка соединения с сервером 0');
            $result = mysqli_query($CONNECT, $query) or die ('Ошибка соединения с сервером');
            $error_msg = '<p class="warning">Ваша фотография изменена</p>';
        }
    }
    else {
        $error_msg = '<p class="error">Вы не загрузили изображение</p>';
    }
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
                <div class="image" <?php if(!empty($photo1)) echo $photo1; if($result0 != FALSE && $result != FALSE) echo $photo1/*'style="background: url(\'images/' . $img_name . '\') no-repeat;"'*/;?>></div>
                <div class="info">
                    <span class="info_str">Альбом: <span>Аватары</span></span>
                    <span class="info_str">Отправитель: <span>Глеб Андреев</span></span>
                    <span class="info_str">Добавлена: <span>1 августа 2018</span></span>
                    <span class="info_str">Нравится: <span>21</span></span>
                </div>
                <form class="el" action="profile_image.php" method="post" enctype="multipart/form-data">
                    <div id="download" class="el" >
                        <input name="userfile" type="file">
                        <input type="submit" value="Загрузить новую фотографию">
                    </div>
                    <input type="radio" name="section" value="1">Область 1
                    <input type="radio" name="section" value="2">Область 2
                    <input type="radio" name="section" value="3">Область 3<br />
                    <input type="radio" name="section" value="4">Область 4
                    <input type="radio" name="section" value="5">Область 5
                    <input type="radio" name="section" value="6">Область 6<br />
                    <input type="radio" name="section" value="7">Область 7
                    <input type="radio" name="section" value="8">Область 8
                    <input type="radio" name="section" value="9">Область 9<br />
                    <input type="submit" name="download_another_img" value="Отправить фотографию">
                </form>
                <form class="el" action="" method="post">
                    <input type="submit" name="delete" value="Удалить фотографию">
                </form>
                <a id="original" href="images/<?php echo $img_name;?>">Загрузить оригинал</a>
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
        <?php
        echo 'ссылка: ' . $photo1; 
        imagedestroy($dest_img);
        imagedestroy($src_img);
        ?>
    </body>
</html><?php
} else {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
	header('Location: ' . $home_url);
}?>