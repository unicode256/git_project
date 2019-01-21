<?php
session_start();
include 'setting.php';
if(!isset($_SESSION['id'])){
    //if(!isset($_SESSION['provisional_id'])){
$error_property_name = "";
$error_property_surname = "";
$error_property_email = "";
$error_property_password = "";
$error_property_password_repeat = "";
$error_msg = "";
$error_msg1 = "";
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
if(isset($_POST['submit'])){
    if (empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat)){
        $error_property_name = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели ваше имя</p>';
    }
    else if (!empty($name) && empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat)){
        $error_property_surname = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели вашу фамилию</p>';
    }
    else if (!empty($name) && !empty($surname) && empty($email) && !empty($password) && !empty($password_repeat)){
        $error_property_email = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не ввели ваш адрес электронной почты</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && empty($password) && !empty($password_repeat)){
        $error_property_password = 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не придумали пароль</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && empty($password_repeat)){
        $error_property_password_repeat= 'style="border-color: red;"';
        $error_msg1 = 'style="padding-bottom: 15px;"';
        $error_msg = '<p class="error">Вы не повторили пароль</p>';
    }
    else if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat'])){
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
            $result0 = mysqli_query($CONNECT, $query0) or die ('Ошибка при отправке запроса 0');
            if(mysqli_num_rows($result0) == 1){
                $error_msg = 'Этот адрес электронной почты уже существует';//разобраться с этим
                $error_property_email = 'style="border-color: red;"';  
            } else {
                //$query = "INSERT INTO `USERS` `reg\_st2` VALUES 0";
                $query = "INSERT INTO `USERS` (`regst2`, `regst3`, `name`, `surname`, `email`, `password`) VALUES (0, 0, '$name', '$surname', '$email', '$password')";
                $result = mysqli_query($CONNECT, $query) or die('Ошибка при отправке запроса 1'); 
                //echo mysqli_error($CONNECT);
                $_SESSION['provisional_id'] = mysqli_insert_id($CONNECT);
                mail($email, "Submition code", $code);
                $to_submit = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/registration2.php';
                header('Location: ' . $to_submit);
            }
        }
    }
    else {
        if(empty($email)) $error_property_email = 'style="border-color: red;"';
        if(empty($password)) $error_property_password = 'style="border-color: red;"';
        if(empty($password_repeat)) $error_property_password_repeat = 'style="border-color: red;"';
        if(empty($name)) $error_property_name = 'style="border-color: red;"';
        if(empty($surname)) $error_property_surname = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вам нужно заполнить всю форму</p>';
        $error_msg1 = 'style="padding-bottom: 15px;"';
    }
}?>
    <html>
	<head>
		<title>Регистрация</title>
		<meta charset="UTF-8">
		<meta http-equiv="Cache-Control" content="private">
		<link href="registr.css" type="text/css" rel="stylesheet">
	</head>
	<body>
        <div id="leftside">
            <h1 id="logo">HY TAKOE</h1>
            <h2>Знакомьтесь свободно.</h2>
            <h3>А мы Вам в этом поможем.</h3>
            <h3 id="last_h3">Нам нужно лишь немножко информации о Вас.</h3>
        </div>
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
                <input id="submit" name="submit" type="submit" value="Идём дальше">
        </form>
        <?php if(!empty($error_msg)) echo $error_msg; ?>
        </div>
</div>
    
	</body>
    </html><?php
//}
/*else {
    $provisional_id = $_SESSION['provisional_id'];
    $query3 = "SELECT * FROM `USERS` WHERE id='$provisional_id'";
    $result3 = mysqli_query($CONNECT, $query3);
    $row3 = mysqli_fetch_array($result3);
    if($row3['reg_st2'] == 0 && $row3['reg_st_3'] == 0){
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/registration2.php';
        header('Location: ' . $redirect);
    }
    if($row3['reg_st2'] == 1 && $row3['reg_st_3'] == 0){
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/registration3.php';
        header('Location: ' . $redirect);
    }
    if($row3['reg_st2'] == 1 && $row3['reg_st_3'] == 1){
        $_SESSION['id'] = $provisional_id;
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $redirect);
    }
}*/
}
else {
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
}?>