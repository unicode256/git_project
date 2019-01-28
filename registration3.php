<?php
if(!isset($_SESSION['id'])){
    if(!isset($_SESSION['provisional_id'])){
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
            <form>
                <input type="submit" value="Всё готово"><br />
                <input type="submit" value="Я не получил(а) Ваше письмо">
            </form>
        </div>
    </body>
</html>