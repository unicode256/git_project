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
    <!DOCTYPE html>
<html>
    <head>
        <title>Регистарция</title>
        <meta charset="UTF-8">
		<meta http-equiv="Cache-Control" content="private">
		<link href="registration2.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1 id="logo">HY TAKOE</h1>
        <h2 id="head1">Всё почти готово</h2>
        <h2 id="head2">Вам осталось указать лишь</h2>
        <form action="registration2.php" method="post" id="section" autocomplete="nope">
            <h2 id="label">Ваш пол:</h2>
            <div id="select_sex" action="registration2.php" method="post">
                <input type="submit" name="male" value="Мужской">
                <input type="submit" name="female" value="Женский">
            </div>
            <h2 id="label">Дату Вашего рождения:</h2>
            <div id="select_date">
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
            </div>
            <h2 id="label">Ваш город:</h2>
            <input type="text" name="city" autocomplete="off" />
            <h2 id="label_last">И подтвердить адрес Вашей электронной почты.</h2>
            <input type="submit" name="submit" value="Понятно, давайте дальше">
        </form>
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