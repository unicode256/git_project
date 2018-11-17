<?php
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'images/';
copy($_FILES['picture']['tmp_name'], $upload_dir . $_FILES['picture']['name']);
echo 'name is ' . $_FILES['picture']['tmp_name'];
?>