<?php
session_start();
include 'setting.php';
//if(!isset($_SESSION['id'])){
    if(!empty($_GET['email']) && !empty($_GET['code'])){
        $enc_email = $_GET['email'];
        $enc_code = $_GET['code'];
        $email = base64_decode($enc_email);
        $code = base64_decode($enc_code);
        echo $email . ' ' . $code;
        $query = "SELECT * FROM `USERS` WHERE `email` = '$email' AND `uniq_code` = '$code'";
        $result = mysqli_query($CONNECT, $query);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result);
            if($row['regst3'] == 1){
                echo 'Регистрация вашего аккаунта уже подтверждена. Дата регистрации - ' . $row['date_of_registr'] . ', дата подтверждения - ' . $row['date_of_confirm'];
            }
            else{
            $query1 = "UPDATE `USERS` SET `regst3` = 1, `date_of_confirm` = NOW() WHERE `email` = '$email' AND `uniq_code` = '$code'";
            mysqli_query($CONNECT, $query1);
            $name = $row['name'];
            $id = $row['id'];
            $_SESSION['id'] = $id;
            if(!empty($_SESSION['provisional_id']))
                $_SESSION['provisional_id'] = "";
            echo $name . ', спасибо Вам за регистрацию. Знакомьтесь свободно.';
            }
        }
        else {
            //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
            //header('Location: ' . $redirect);
            echo 'Произошла ошибка. Такой страницы не существует. Извините.';
        }
    }
    else {
        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $redirect);
        echo 'error 2';
    }
//}
/*else{
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $redirect);
    echo 'error 3';
}*/
?>