<?php
session_start();
include 'setting.php';
$error_property_email = "";
$error_property_password = "";
$error_property_password_repeat = "";
$error_property_name = "";
$error_property_surname = "";
$error_birth_day = "";
$error_birth_month = "";
$error_birth_year = "";
$error_sex = "";
$error_msg = "";
$error_msg1 = "";
$wrong_repeat = "";
$error_city = "";
$stage1 = 0;
$stage2 = 0;
$stage3 = 0;
if(isset($_POST['submit1'])){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
}
if(isset($_POST['submit2'])){
    $city = $_POST['city'];
    $sex = $_POST['sex'];
    $birth_day = $_POST['birth_day'];
    $birth_month = $_POST['birth_month'];
    $birth_year = $_POST['birth_year'];
    $birth = $birth_year . '-' . $birth_month . '-' . $birth_day;
}
if(empty($_SESSION['id'])){
	if(isset($_POST['submit1'])){
	    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat'])/* && !empty($_POST['sex']) && !empty($_POST['city']) && ($_POST['birth_day'] != 'День') && ($_POST['birth_month'] != 'Месяц') && ($_POST['birth_year'] != 'Год')*/){
            if ($password != $password_repeat){
                $password = "";
                $password_repeat = "";
                $error_msg = '<p class="error">Пароли не совпадают</p>';
                $error_msg1 = 'style="padding-bottom: 15px;"';
                $error_property_password = 'style="border-color: red;"';
                $error_property_password_repeat = 'style="border-color: red;"';
            }
            else {
                $code = rand(11000, 32000);
                $birth = $birth_year . '-' . $birth_month . '-' . $birth_day;
		        $query0 = "SELECT * FROM `USERS` WHERE email='$email'";
		        $result0 = mysqli_query($CONNECT, $query0);
		        if(mysqli_num_rows($result0) == 1){
                    $error_msg = 'Этот адрес электронной почты уже существует';//разобраться с этим
                    $error_property_email = 'style="border-color: red;"';  
		        } else {
		        	$query = "INSERT INTO `USERS` (`name`, `surname`, `email`, `birth`, `password`, `sex`, `code`, `auth`) VALUES ( '$name', '$surname', '$email', '$birth', '$password', '$sex', '$code', 0)";
		        	$result = mysqli_query($CONNECT, $query)
		        	or die('Ошибка при отправке запроса');
		        	$id = mysqli_insert_id($CONNECT);
		        	mail($email, "Submition code", $code);
		        	$to_submit = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/submit.php?id=' . $id;
		        	header('Location: ' . $to_submit);
                }
            }
        }
    else if (empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat)/* && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')*/){
        $error_property_name = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели ваше имя</p>';
    }
    else if (!empty($name) && empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat)/* && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')*/){
        $error_property_surname = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели вашу фамилию</p>';
    }
    else if (!empty($name) && !empty($surname) && empty($email) && !empty($password) && !empty($password_repeat)/* && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')*/){
        $error_property_email = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели ваш адрес электронной почты</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && empty($password) && !empty($password_repeat)/* && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')*/){
        $error_property_password = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не придумали пароль</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && empty($password_repeat)/* && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')*/){
        $error_property_password_repeat= 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не повторили пароль</p>';
    }
    /*else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_sex = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не указали ваш пол</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_city = 'style="border-color: red;"';
        $error_msg1 = 'style="padding_bottom: 15px;"';
        $error_msg = '<p class="error">Вы не указали ваш город</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day == 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_birth_day = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не указали день вашего рождения</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month == 'Месяц') && ($birth_year != 'Год')){
        $error_birth_month = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не указали месяц вашего рождения</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year == 'Год')){
        $error_birth_year = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не указали год вашего рождения</p>';
    }*/
    else {
        if(empty($email)) $error_property_email = 'style="border-color: red;"';
        if(empty($password)) $error_property_password = 'style="border-color: red;"';
        if(empty($password_repeat)) $error_property_password_repeat = 'style="border-color: red;"';
        if(empty($name)) $error_property_name = 'style="border-color: red;"';
        if(empty($surname)) $error_property_surname = 'style="border-color: red;"';
        //if(empty($sex)) $error_sex = 'style="border-color: red;"';
        //if(empty($city)) $error_city = 'style="border-color: red;"';
        //if($birth_day == 'День') $error_birth_day = 'style="border-color: red;"';
        //if($birth_month == 'Месяц') $error_birth_month = 'style="border-color: red;"';
        //if($birth_year == 'Год') $error_birth_year = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вам нужно заполнить всю форму</p>';
        $error_msg1 = 'style="padding-bottom: 15px;"';
    }
    ?>
<html>
	<head>
		<title>Регистрация</title>
		<meta charset="UTF-8">
		<meta http-equiv="Cache-Control" content="private">
		<link href="registr.css" type="text/css" rel="stylesheet">
	</head>
	<body>
	<h1 id="leftside">HY TAKOE</h1>
        <div id="main_rightside">
        <div id="rightside" <?php if(!empty($error_msg1)) echo $error_msg1;?>>
            <h1 id="h1_rightside">Регистрация</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf8_unicode_520_ci">
		<label>Напишите Ваше имя:<br />
                <input type="text" name="name" <?php if(!empty($error_property_name)) echo $error_property_name;?>value="<?php if(!empty($name)) echo $name;?>"></label><br />
                <label>Напишите Вашу фамилию:<br />
                <input type="text" name="surname" <?php if(!empty($error_property_surname)) echo $error_property_surname;?>value="<?php if(!empty($surname)) echo $surname;?>"></label><br />
                <label>И Ваш адрес электронной почты:<br />
                <input type="text" name="email" <?php if(!empty($error_property_email)) echo $error_property_email;?>value="<?php if(!empty($email)) echo $email;?>"></label><br />
                <label>Теперь придумайте пароль:<br />
                <input type="password" name="password" <?php if(!empty($error_property_password)) echo $error_property_password;?>value="<?php if(!empty($password)) echo $password;?>"></label><br />
                <label>И напишите его повторно:<br />
                <input type="password" name="password_repeat" <?php if(!empty($error_property_password_repeat)) echo $error_property_password_repeat;?>value="<?php if(!empty($password_repeat)) echo $password_repeat;?>"></label><br />
                <input id="submit" name="submit1" type="submit" value="Идём дальше">
    </form>
    <?php if(!empty($error_msg)) echo $error_msg; ?>
	</body>
    </html><?php
}
}
/*if(empty($_SESSION['id'])){
    //if(!isset($_POST['submit1'])){?>
<html>
	<head>
		<title>Регистрация</title>
		<meta charset="UTF-8">
		<meta http-equiv="Cache-Control" content="private">
		<link href="registr.css" type="text/css" rel="stylesheet">
	</head>
	<body>
	<h1 id="leftside">HY TAKOE</h1>
        <div id="main_rightside">
        <div id="rightside" <?php if(!empty($error_msg1)) echo $error_msg1;?>>
            <h1 id="h1_rightside">Регистрация</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf8_unicode_520_ci">
		<label>Напишите Ваше имя:<br />
                <input type="text" name="name" <?php if(!empty($error_property_name)) echo $error_property_name;?>value="<?php if(!empty($name)) echo $name;?>"></label><br />
                <label>Напишите Вашу фамилию:<br />
                <input type="text" name="surname" <?php if(!empty($error_property_surname)) echo $error_property_surname;?>value="<?php if(!empty($surname)) echo $surname;?>"></label><br />
                <label>И Ваш адрес электронной почты:<br />
                <input type="text" name="email" <?php if(!empty($error_property_email)) echo $error_property_email;?>value="<?php if(!empty($email)) echo $email;?>"></label><br />
                <label>Теперь придумайте пароль:<br />
                <input type="password" name="password" <?php if(!empty($error_property_password)) echo $error_property_password;?>value="<?php if(!empty($password)) echo $password;?>"></label><br />
                <label>И напишите его повторно:<br />
                <input type="password" name="password_repeat" <?php if(!empty($error_property_password_repeat)) echo $error_property_password_repeat;?>value="<?php if(!empty($password_repeat)) echo $password_repeat;?>"></label><br />
                <input id="submit" name="submit1" type="submit" value="Идём дальше">
    </form>
    <?php if(!empty($error_msg)) echo $error_msg; ?>
	</body>
    </html><?php
    //}
}*/
else {
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
}
?>