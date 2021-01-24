<?php
include "../../../databases/db_connection.php";

session_start();
include "../../scripts/check_authentication.php";
include "../../scripts/check_is_admin.php";
include "../../scripts/password.php";

// Make sure all paramaters have been passed
if( !isset($_POST['username']) || !isset($_POST['password']) || !checkPassword($_POST['password'])){
    header('Location: /views/users/new_user.php');
    die();
}

// Check if the username exists
$sql = $file_db->prepare("SELECT * FROM users WHERE `username` = ?");
$sql->execute([$_POST['username']]);
$username = $sql->fetch();
if(!empty($username)){
    header('Location: /views/users/new_user.php?error=username');
    die();
}

// Create the user
$sql = $file_db->prepare("INSERT INTO users VALUES (?,?,?,?)");
$result = $sql->execute([$_POST['username'], hash_password( $_POST['password']), isset($_POST['is_admin']), isset($_POST['is_active'])]);

// Redirect the user
header('Location: /views/users/show_users.php?');
die();

?>
