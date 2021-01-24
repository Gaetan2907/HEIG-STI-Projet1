<?php
include "../../../databases/db_connection.php";

session_start();
include "../../scripts/check_authentication.php";

// Check if the new password was sent
if( !isset($_POST['password'])){
    header('Location: views/users/change_password.php');
    die();
}

// Update the password associated with user
$sql = $file_db->prepare("UPDATE users SET `password` = ? WHERE `username` = ?");
$sql->execute([password_hash($_POST['password'], PASSWORD_BCRYPT), $_SESSION['user']]);

header('Location: /views/users/change_password.php');
die();


?>
