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
$wrong_repeat = "";
$error_city = "";
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$city = $_POST['city'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$sex = $_POST['sex'];
$birth_day = $_POST['birth_day'];
$birth_month = $_POST['birth_month'];
$birth_year = $_POST['birth_year'];
$birth = $birth_year . '-' . $birth_month . '-' . $birth_day;
if(!isset($_SESSION['id'])){
	if(isset($_POST['submit'])){
        /*if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
            if ($password != $password_repeat){
                $password = "";
                $password_repeat = "";
                $error_msg = '<p class="error">Пароли не совпадают</p>';
                $error_property_password = 'style="border-color: red;"';
                $error_property_password_repeat = 'style="border-color: red;"';
            }
        }*/
	    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat']) && !empty($_POST['sex']) && !empty($_POST['city']) && ($_POST['birth_day'] != 'День') && ($_POST['birth_month'] != 'Месяц') && ($_POST['birth_year'] != 'Год')){
            if ($password != $password_repeat){
                $password = "";
                $password_repeat = "";
                $error_msg = '<p class="error">Пароли не совпадают</p>';
                $error_property_password = 'style="border-color: red;"';
                $error_property_password_repeat = 'style="border-color: red;"';
            }
            else {
                $code = rand(12000, 32000);
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
    else if (empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_property_name = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не ввели ваше имя</p>';
    }
    else if (!empty($name) && empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_property_surname = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не ввели вашу фамилию</p>';
    }
    else if (!empty($name) && !empty($surname) && empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_property_email = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не ввели ваш адрес электронной почты</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_property_password = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не придумали пароль</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_property_password_repeat= 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не повторили пароль</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_sex = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не указали ваш пол</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_city = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не указали ваш город</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day == 'День') && ($birth_month != 'Месяц') && ($birth_year != 'Год')){
        $error_birth_day = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не указали день вашего рождения</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month == 'Месяц') && ($birth_year != 'Год')){
        $error_birth_month = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не указали месяц вашего рождения</p>';
    }
    else if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($sex) && !empty($city) && ($birth_day != 'День') && ($birth_month != 'Месяц') && ($birth_year == 'Год')){
        $error_birth_year = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вы не указали год вашего рождения</p>';
    }
    else /*if(empty($name) && empty($surname) && empty($email) && empty($password) && empty($password_repeat) && empty($sex) && ($birth_day == 'День') && ($birth_month == 'Месяц') && ($birth_year == 'Год'))*/{
        if(empty($email)) $error_property_email = 'style="border-color: red;"';
        if(empty($password)) $error_property_password = 'style="border-color: red;"';
        if(empty($password_repeat)) $error_property_password_repeat = 'style="border-color: red;"';
        if(empty($name)) $error_property_name = 'style="border-color: red;"';
        if(empty($surname)) $error_property_surname = 'style="border-color: red;"';
        if(empty($sex)) $error_sex = 'style="border-color: red;"';
        if(empty($city)) $error_city = 'style="border-color: red;"';
        if($birth_day == 'День') $error_birth_day = 'style="border-color: red;"';
        if($birth_month == 'Месяц') $error_birth_month = 'style="border-color: red;"';
        if($birth_year == 'Год') $error_birth_year = 'style="border-color: red;"';
        $error_msg = '<p class="error">Вам нужно заполнить всю форму</p>';
	}
}
}
if(empty($_SESSION['id'])){?>
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
        <div id="rightside">
            <h1 id="h1_rightside">Регистрация</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf8_unicode_520_ci">
		<label>Ваше имя:<br />
                <input type="text" name="name" <?php if(!empty($error_property_name)) echo $error_property_name;?>value="<?php if(!empty($name)) echo $name;?>"></label><br />
                <label>Ваша фамилия:<br />
                <input type="text" name="surname" <?php if(!empty($error_property_surname)) echo $error_property_surname;?>value="<?php if(!empty($surname)) echo $surname;?>"></label><br />
                <label>Ваш адрес электронной почты:<br />
                <input type="text" name="email" <?php if(!empty($error_property_email)) echo $error_property_email;?>value="<?php if(!empty($email)) echo $email;?>"></label><br />
                <label>Ваш город:<br />
                <input type="text" name="city" <?php if(!empty($error_city)) echo $error_city;?>value="<?php if(!empty($city)) echo $city;?>"></label><br />
                <label>Придумайте пароль:<br />
                <input type="password" name="password" <?php if(!empty($error_property_password)) echo $error_property_password;?>value="<?php if(!empty($password)) echo $password;?>"></label><br />
                <label>Повторите пароль:<br />
                <input type="password" name="password_repeat" <?php if(!empty($error_property_password_repeat)) echo $error_property_password_repeat;?>value="<?php if(!empty($password_repeat)) echo $password_repeat;?>"></label><br />
                <label <?php if(!empty($error_sex)) echo $error_sex;?>>Укажите пол:<br />
                <!--<button id="button1" name="sex" value="male">Мужчина</button>
                <button name="sex" value="female">Женщина</button><br />-->
                <input class="sex" id="sex1" type="radio" name="sex" value="male" <?php if($sex == 'male') echo 'checked';?>>Мужчина
                <input class="sex" id="sex2" type="radio" name="sex" value="female" <?php if($sex == 'female') echo 'checked';?>>Женщина</label><br />
                <label>Укажите вашу дату рождения:<br />
                <select id="day" name="birth_day" <?php if(!empty($error_birth_day)) echo $error_birth_day;?>>
                    <option>День</option>
                    <option <?php if($birth_day == '01') echo 'selected';?> value="01">01</option>
                    <option <?php if($birth_day == '02') echo 'selected';?> value="01">02</option>
                    <option <?php if($birth_day == '03') echo 'selected';?> value="02">03</option>
                    <option <?php if($birth_day == '04') echo 'selected';?> value="04">04</option>
                    <option <?php if($birth_day == '05') echo 'selected';?> value="05">05</option>
                    <option <?php if($birth_day == '06') echo 'selected';?> value="06">06</option>
                    <option <?php if($birth_day == '07') echo 'selected';?> value="07">07</option>
                    <option <?php if($birth_day == '08') echo 'selected';?> value="08">08</option>
                    <option <?php if($birth_day == '09') echo 'selected';?> value="09">09</option>
                    <option <?php if($birth_day == '10') echo 'selected';?> value="10">10</option>
                    <option <?php if($birth_day == '11') echo 'selected';?> value="11">11</option>
                    <option <?php if($birth_day == '12') echo 'selected';?> value="12">12</option>
                    <option <?php if($birth_day == '13') echo 'selected';?> value="13">13</option>
                    <option <?php if($birth_day == '14') echo 'selected';?> value="14">14</option>
                    <option <?php if($birth_day == '15') echo 'selected';?> value="15">15</option>
                    <option <?php if($birth_day == '16') echo 'selected';?> value="16">16</option>
                    <option <?php if($birth_day == '17') echo 'selected';?> value="17">17</option>
                    <option <?php if($birth_day == '18') echo 'selected';?> value="18">18</option>
                    <option <?php if($birth_day == '19') echo 'selected';?> value="19">19</option>
                    <option <?php if($birth_day == '20') echo 'selected';?> value="20">20</option>
                    <option <?php if($birth_day == '21') echo 'selected';?> value="21">21</option>
                    <option <?php if($birth_day == '22') echo 'selected';?> value="22">22</option>
                    <option <?php if($birth_day == '23') echo 'selected';?> value="23">23</option>
                    <option <?php if($birth_day == '24') echo 'selected';?> value="24">24</option>
                    <option <?php if($birth_day == '25') echo 'selected';?> value="25">25</option>
                    <option <?php if($birth_day == '26') echo 'selected';?> value="26">26</option>
                    <option <?php if($birth_day == '27') echo 'selected';?> value="27">27</option>
                    <option <?php if($birth_day == '28') echo 'selected';?> value="28">28</option>
                    <option <?php if($birth_day == '29') echo 'selected';?> value="29">29</option>
                    <option <?php if($birth_day == '30') echo 'selected';?> value="30">30</option>
                    <option <?php if($birth_day == '31') echo 'selected';?> value="31">31</option>
                </select>
                <select name="birth_month" <?php if(!empty($error_birth_month)) echo $error_birth_month;?>>
                    <option>Месяц</option>
                    <option <?php if($birth_month == '01') echo 'selected';?> value="01">Январь</option>
                    <option <?php if($birth_month == '02') echo 'selected';?> value="02">Февраль</option>
                    <option <?php if($birth_month == '03') echo 'selected';?> value="03">Март</option>
                    <option <?php if($birth_month == '04') echo 'selected';?> value="04">Апрель</option>
                    <option <?php if($birth_month == '05') echo 'selected';?> value="05">Май</option>
                    <option <?php if($birth_month == '06') echo 'selected';?> value="06">Июнь</option>
                    <option <?php if($birth_month == '07') echo 'selected';?> value="07">Июль</option>
                    <option <?php if($birth_month == '08') echo 'selected';?> value="08">Август</option>
                    <option <?php if($birth_month == '09') echo 'selected';?> value="09">Сентябрь</option>
                    <option <?php if($birth_month == '10') echo 'selected';?> value="10">Октябрь</option>
                    <option <?php if($birth_month == '11') echo 'selected';?> value="11">Ноябрь</option>
                    <option <?php if($birth_month == '12') echo 'selected';?> value="12">Декабрь</option>
                </select>
                <select name="birth_year" <?php if(!empty($error_birth_year)) echo $error_birth_year;?>>
                    <option>Год</option>
                    <option <?php if($birth_year == '2002') echo 'selected';?> value="2002">2002</option>
                    <option <?php if($birth_year == '2001') echo 'selected';?> value="2001">2001</option>
                    <option <?php if($birth_year == '2000') echo 'selected';?> value="2000">2000</option>
                    <option <?php if($birth_year == '1999') echo 'selected';?> value="1999">1999</option>
                    <option <?php if($birth_year == '1998') echo 'selected';?> value="1998">1998</option>
                    <option <?php if($birth_year == '1997') echo 'selected';?> value="1997">1997</option>
                    <option <?php if($birth_year == '1996') echo 'selected';?> value="1996">1996</option>
                    <option <?php if($birth_year == '1995') echo 'selected';?> value="1995">1995</option>
                    <option <?php if($birth_year == '1994') echo 'selected';?> value="1994">1994</option>
                    <option <?php if($birth_year == '1993') echo 'selected';?> value="1993">1993</option>
                    <option <?php if($birth_year == '1992') echo 'selected';?> value="1992">1992</option>
                    <option <?php if($birth_year == '1991') echo 'selected';?> value="1991">1991</option>
                </select>
                </label><br />
                <input id="submit" name="submit" type="submit" value="Зарегистрироваться">
    </form>
    <?php if(!empty($error_msg)) echo $error_msg; ?>
	</body>
	</html><?php
}
else {
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
}
?>