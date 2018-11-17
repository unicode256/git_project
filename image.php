<?php
    if ($_FILES['userfile']['error'] > 0){
        echo 'Проблема: ';
        switch ($_FILES['userfile']['error']){
            case 1: echo 'размер файла очень большой(upload_max_filesize)'; break;
            case 2: echo 'размер файла очень большой(max_file_size)'; break;
            case 3: echo 'загружена только часть файла'; break;
            case 4: echo 'файл не загружен'; break;
        }
        exit;
    }
    if ($_FILES['userfile']['type'] != 'image/png'){
        echo 'Проблема: файл не является текстовым';
        exit;
    }
    $upfile = 'images/' . $_FILES['userfile']['name'];
    if($_FILES['userfile']['tmp_name']){
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)){
            echo 'Проблема: невозможно переместить файл в каталог назначения';
            exit;
        }
    }
    else {
        echo 'Проблема: возможна атака через загрузку файла. Файл: ';
        echo $_FILES['userfiles']['name'];
        exit;
    }
    echo 'Файл успешно загружен.';
?>