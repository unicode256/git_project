<?php
session_start();
include 'setting.php';
if(!isset($_SESSION['id'])){
    if(isset($_SESSION['provisional_id'])){
        $error_msg = "";
        $id = $_SESSION['provisional_id'];
        $query = "SELECT * FROM `USERS` WHERE `id` = '$id'";
        $result = mysqli_query($CONNECT, $query);
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $surname = $row['surname'];
        $email = $row['email'];
        $enc_email = str_replace("=", "", base64_encode($email));//перекинуть потом пару символов вперёд
        $code = rand(11000, 30000);
        $enc_code = str_replace("=", "", base64_encode($code));//и здесь тоже

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
                <p style="font-family: \'Helvetica\'; width: 600px; margin-left: auto; margin-right: auto; margin-top: 20px;"><a href="localhost/project/endofregistr.php?email=' . $enc_email . '&code=' . $enc_code . '"><img src="cid:2.png"></a></p>
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
        $query1 = "UPDATE `USERS` SET `uniq_code` = '$code' WHERE `id` = '$id'";
        mysqli_query($CONNECT, $query1);
        
        if($_POST['ready']){
            $query2 = "SELECT * FROM `USERS` WHERE `id` = '$id'";
            $result2 = mysqli_query($CONNECT, $query2) or die ('Ошибка');
            $row2 = mysqli_fetch_array($result2);
            if($row2['uniq_code'] == $code){
                if($row['regst3'] == 1){
                    $to_submit = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/endofregistr.html';
                    header('Location: ' . $to_submit);
                }
                else {
                    $error_msg = '<p class="error">Вы не подтвердили свой адрес</p>';
                }
            }
            else {
                $error_msg = '<p class="error">По каким-то причинам не получилось подтвердить регистрацию. Запросите пиьсмо ещё раз.</p>';
            }
        }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Регистарция</title>
        <meta charset="UTF-8">
        <meta http-equiv="Cache-Control" content="private">
        <link href="registration3-style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div>
            <h1 id="logo">HY TAKOE</h1>
            <h2 id="line">Подтверждение адреса Вашей электронной почты</h2>
            <h2 class="margin">Мы отправили Вам на почту письмо.</h2>
            <h2 class="margin">Для подтверждения регистрации</h2>
            <h2>Прочитайте письмо и нажмите в письме</h2>
            <h2>"Подтвердить"</h2>
            <form action="registration3.php" method="post">
                <input name="ready" type="submit" value="Всё готово"><br />
                <input name="not_ready" type="submit" value="Я не получил(а) Ваше письмо">
            </form>
            <?php if(!empty($error_msg)) echo $error_msg;?>
        </div>
    </body>
</html><?php 
    }
    else {
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	    header('Location: ' . $redirect);
    }
}
else {
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $redirect);
}