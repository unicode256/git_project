<?php
session_start();
if(!isset($_SESSION['id'])){
    //if(!isset($_SESSION['provisional_id'])){
$id = 43;//$_SESSION['provisional_id'];
$error_property_sex = "";
$error_property_birth_day = "";
$error_property_birth_month = "";
$error_property_birth_year = "";
$error_property_city = "";
$male_input_style = "";
$female_input_style = "";
$error_msg = "";
$error_msg1 = "";

//---------- секция, где написаны инструкции, которые необходимы для корректной отправки письма с подтверждением
$attach = array(
    'imgs/1.png',
    'imgs/2.png'
);
$text = '
<html>
    <body>
        <p style="width: 600px; margin-left: auto; margin-right: auto;"><img src="cid:1.png"></p>
        <p style="color: #000; font-family: \'Helvetica\'; font-size: 15px; width: 600px; text-align: center; margin-top: 20px; margin-left: auto; margin-right: auto;">
        Подтвердите, что вы получили это письмо – и Вы сможете войти в свой аккаунт.</p>
        <p style="font-family: \'Helvetica\'; width: 600px; margin-left: auto; margin-right: auto; margin-top: 20px;"><a href="google.com"><img src="cid:2.png"></a></p>
        <p style="font-family: \'Helvetica\'; color: #000; width: 600px; text-align: center; font-size: 15px; margin-top: 20px; margin-left: auto; margin-right: auto;">Также, рекомендуем Вам ознакомиться с 
        <a href="google.com" style="color: #57A7FF; text-decoration: none;">правилами</a> работы нашего сайта.</p>
    </body>
    </html>
';
$from = "confirmation@nytakoe.com";
$to = "alisa.andreeva3301@gmail.com";
$subject = "Письмо для подтверждения регистрации";
  
$headers = "From: $from\r\n";
$headers .= "Subject: $subject\r\n";
$headers .= "Date: " . date("r") . "\r\n";
$headers .= "X-Mailer: zm php script\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .="Content-Type: multipart/alternative;\r\n";
$baseboundary = "------------" . md5(microtime());
$headers .= "  boundary=\"$baseboundary\"\r\n";

$message  =  "--$baseboundary\r\n";
$message .= "Content-Type: text/plain;\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= "--$baseboundary\r\n";

$newboundary = "------------" . md5(microtime());
$message .= "Content-Type: multipart/related;\r\n";
$message .= "  boundary=\"$newboundary\"\r\n\r\n\r\n";
$message .= "--$newboundary\r\n";
$message .= "Content-Type: text/html; ".
"charset=utf-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $text . "\r\n\r\n";
  
foreach($attach as $filename){
    $mimeType='image/png';
    $fileContent = file_get_contents($filename,true);
    $filename = basename($filename);
    $message.="--$newboundary\r\n";
    $message.="Content-Type: $mimeType;\r\n";
    $message.=" name=\"$filename\"\r\n";
    $message.="Content-Transfer-Encoding: base64\r\n";
    $message.="Content-ID: <$filename>\r\n";
    $message.="Content-Disposition: inline;\r\n";
    $message.=" filename=\"$filename\"\r\n\r\n";
    $message.=chunk_split(base64_encode($fileContent));
}  

$message.="--$newboundary--\r\n\r\n";
$message.="--$baseboundary--\r\n";
  
$result = mail($to, $subject, $message , $headers);
if($result){
    echo "Письмо успешно отправлено!";
}else{
    echo "Письмо не отправлено!";
}
//---------- конец этой секции
if(isset($_POST['male'])){
    $sex = 'male';
    $male_input_style = 'style="font-weight: bold; border-color: #fff;"';
}
if(isset($_POST['female'])){
    $sex = 'female';
    $female_input_style = 'style="font-weight: bold; border-color: #fff;"';
}
    $birth_day = $_POST['birth_day'];
    $birth_month = $_POST['birth_month'];
    $birth_year = $_POST['birth_year'];
    $birth = $birth_year . '-' . $birth_month . '-' . $birth_day;
    $city = $_POST['city'];
if(isset($_POST['submit'])){
    if (!isset($sex) && !empty($birth_day) && !empty($birth_month) && !empty($birth_year) && !empty($city)){
        $error_property_sex = 'style="border-color: #96000d;"';
        $error_msg = '<p class="error">Вы не указали ваш пол</p>';
    }
    else if ((isset($_POST['male']) || isset($_POST['female'])) && empty($birth_day) && !empty($birth_month) && !empty($birth_year) && !empty($city)){
        $error_property_birth_day = 'style="border-color: #96000d;"';
        $error_msg = '<p class="error">Вы не указали день Вашего рождения</p>';
    }
    else if ((isset($_POST['male']) || isset($_POST['female'])) && !empty($birth_day) && empty($birth_month) && !empty($birth_year) && !empty($city)){
        $error_property_birth_month = 'style="border-color: #96000d;"';
        $error_msg = '<p class="error">Вы не указали месяц Вашего рождения</p>';
    }
    else if ((isset($_POST['male']) || isset($_POST['female'])) && !empty($birth_day) && !empty($birth_month) && empty($birth_year) && !empty($city)){
        $error_property_birth_year = 'style="border-color: #96000d;"';
        $error_msg = '<p class="error">Вы не указали год Вашего рождения</p>';
    }
    else if ((isset($_POST['male']) || isset($_POST['female'])) && !empty($birth_day) && !empty($birth_month) && !empty($birth_year) && empty($city)){
        $error_property_city= 'style="background-color: rgba(143, 0, 0, 1);"';
        $error_msg = '<p class="error">Вы не написали Ваш город</p>';
    }
    else if((isset($_POST['male']) || isset($_POST['female'])) && !empty($birth_day) && !empty($birth_month) && !empty($birth_year) && !empty($city)){
            $code = rand(11000, 32000);
            $query = "UPDATE `USERS` SET `regst2` = 1, `city` = '$city', `sex` = '$sex', `birth` = '$birth' WHERE `id` = '$id'";
            $result = mysqli_query($CONNECT, $query); //or die('Ошибка при отправке запроса 1'); 
            echo mysqli_error($CONNECT);
            $to_submit = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/registration2.php';
            header('Location: ' . $to_submit);
    }
    else {
        if(!(isset($_POST['male']) || isset($_POST['female']))) $error_property_sex = 'style="border-color: #96000d;"';
        if(empty($birth_day)) $error_property_birth_day = 'style="border-color: #96000d;"';
        if(empty($birth_month)) $error_property_birth_month = 'style="border-color: #96000d;"';
        if(empty($birth_year)) $error_property_birth_year = 'style="border-color: #96000d;"';
        if(empty($city)) $error_property_city = 'style="background-color: rgba(255, 54, 54, 0.4);"';
        $error_msg = '<p class="error">Вам нужно заполнить всю форму</p>';
    }
}
?>
    <!DOCTYPE html>
<html>
    <head>
        <title>Регистарция</title>
        <meta charset="UTF-8">
		<meta http-equiv="Cache-Control" content="private">
		<link href="registration2-style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1 id="logo">HY TAKOE</h1>
        <h2 id="head1">Всё почти готово</h2>
        <h2 id="head2">Вам осталось указать лишь</h2>
        <form action="registration2.php" method="post" id="section" autocomplete="nope">
            <h2 id="label">Ваш пол:</h2>
            <div id="select_sex" action="registration2.php" method="post">
                <input type="submit" name="male" value="Мужской" <?php if(!empty($male_input_style)) echo $male_input_style;?>>
                <input type="submit" name="female" value="Женский" <?php if(!empty($female_input_style)) echo $female_input_style;?>>
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
            <input type="text" name="city" autocomplete="off" <?php if(!empty($error_property_city)) echo $error_property_city;?> value="<?php if(!empty($city)) echo $city;?>"/>
            <h2 id="label_last">И подтвердить адрес Вашей электронной почты.</h2>
            <input type="submit" name="submit" value="Понятно, давайте дальше">
            <?php if(!empty($error_msg)) echo $error_msg;?>
        </form>
    </body>
    </html><?php echo $error;
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