<?php
include "../../../databases/db_connection.php";

session_start();
include "../../scripts/check_authentication.php";
include "../../scripts/check_is_admin.php";
include "../../scripts/password.php";

// Make sure all paramaters have been passed
if( !isset($_POST['username']) || !isset($_POST['password']) ){
    header('Location: /views/users/show_users.php');
    die();
}
// Check if we need to update the password
if(empty($_POST['password'])){
    // Update the user
    $sql = $file_db->prepare("UPDATE users SET `is_admin` = ? WHERE `username` = ?");
    $result = $sql->execute([isset($_POST['is_admin']), $_POST['username']]);
}
else{
    // Update the user
    $sql = $file_db->prepare("UPDATE users SET `password` = ?, `is_admin` = ? WHERE `username` = ?");
    $result = $sql->execute([hash_password($_POST['password']), isset($_POST['is_admin']), $_POST['username']]);
}

// Redirect the user
header('Location: /views/users/show_users.php');
die();

?>
