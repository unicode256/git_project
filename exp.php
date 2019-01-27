<?php
$file_name="images/ava.png";
$subj="Отправка изображения";
$bound="spravkaweb-1234";
$headers="From: \"vega\" <info@card.vl.ru> \n";
$headers.="To: [email=alisa.andreeva3301@gmail.com]webmaster@vega.pk.ru[/email] \n";
$headers.="Subject: $subj \n";
$headers.="Mime-Version: 1.0 \n";
$headers.="Content-Type: multipart/alternative; boundary=\"$bound\" \n";
$headers="--$bound \n";
$headers.="Content-type: text/html; charset=\"utf-8\" \n";
$headers.="Content-Transfer-Encoding: 7bit \n";
$body.="<h3>Привет</h3>
Это проба отправки письма с прикрепленной картинкой.<br />
А вот и сама картинка:<br />
<img src=\"cid:spravkaweb_img_1\">";
$headers.="--$bound \n";
$headers.="Content-Type: image/png; name=\"".basename($file_name)."\" \n";
$headers.="Content-Transfer-Encoding:base64 \n";
$headers.="Content-ID: <spravkaweb_img_1> \n";
$f=fopen($file_name,"rb");
$body.=base64_encode(fread($f,filesize($file_name)))." \n";
$headers.="--$bound-- \n";
$result = mail("alisa.andreeva3301@gmail.com", $subj, $body, $headers);
var_dump($result);
?>