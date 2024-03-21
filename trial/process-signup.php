<?php
$password_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
print_r($_POST);
var_dump($password_hash);

