<?php

$attach = array(
    'imgs/1.png',
    'imgs/2.png'
);
// чтобы отображалась картинка и ее не было в аттаче
// путь к картинке задается через CID: - Content-ID
// тестовая верстка письма
$text = '
    <div style="width: 700px; margin: 0 auto;">
        <h1>тело письма с картинкой</h1>
        <h2>Блок по центру</h2>
        <p>
        <img style="float: left;" src="cid:1.png" />
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки.
        <br/>
        <img style="float: left;" src="cid:2.png" />
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки. 
        Какой-то текст вокруг картинки.
        </p>
    </div>
';
  
// E-mail отправителя
$from = "test@test.com";
// E-mail получателя
$to = "alisa.andreeva3301@gmail.com";
// Тема письма
$subject = "Тема письма";
  
// Заголовки письма === >>>
$headers = "From: $from\r\n";
//$headers .= "To: $to\r\n";
$headers .= "Subject: $subject\r\n";
$headers .= "Date: " . date("r") . "\r\n";
$headers .= "X-Mailer: zm php script\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .="Content-Type: multipart/alternative;\r\n";
// генерируем базовый разделитель
$baseboundary = "------------" . md5(microtime());
$headers .= "  boundary=\"$baseboundary\"\r\n";
// <<< ====================
  
// Тело письма === >>>
$message  =  "--$baseboundary\r\n";
$message .= "Content-Type: text/plain;\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= "--$baseboundary\r\n";
// генерируем разделитель для картинок
$newboundary = "------------" . md5(microtime());
$message .= "Content-Type: multipart/related;\r\n";
$message .= "  boundary=\"$newboundary\"\r\n\r\n\r\n";
$message .= "--$newboundary\r\n";
$message .= "Content-Type: text/html; ".
"charset=utf-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $text . "\r\n\r\n";
// <<< ==============
  
// прикрепляем файлы ===>>>
foreach($attach as $filename){
    $mimeType='image/png';
      // получаем картинку
    $fileContent = file_get_contents($filename,true);
    $filename = basename($filename);
    $message.="--$newboundary\r\n";
    $message.="Content-Type: $mimeType;\r\n";
    $message.=" name=\"$filename\"\r\n";
    $message.="Content-Transfer-Encoding: base64\r\n";
    $message.="Content-ID: <$filename>\r\n";
    $message.="Content-Disposition: inline;\r\n";
    $message.=" filename=\"$filename\"\r\n\r\n";
      // кодируем картинку
  $message.=
chunk_split(base64_encode($fileContent));
}
// <<< ====================
  
// заканчиваем тело письма, дописываем разделители
$message.="--$newboundary--\r\n\r\n";
$message.="--$baseboundary--\r\n";
  
// отправка письма
$result = mail($to, $subject, $message , $headers);
if($result){
    echo "Письмо успешно отправлено!";
}else{
    echo "Письмо не отправлено!";
}