<?php include "../../../databases/db_connection.php"; ?>

<?php
session_start();

include "../../scripts/check_authentication.php";
include "../../scripts/check_is_admin.php";

if ($_POST["csrf_token"] != $_SESSION["csrf_token"]) {
    // Reset token
    unset($_SESSION["csrf_token"]);
    die("validation token CSRF token échouée");
}

// Make sure all paramaters have been passed
if( !isset($_POST['username']) ){
    header('Location: /views/users/show_users.php');
    die();
}
// Update the user
$sql = $file_db->prepare("UPDATE users SET `is_active` = 0 WHERE `username` = ?");
$result = $sql->execute([$_POST['username']]);

// Redirect the user
header('Location: /views/users/show_users.php');
die();

?>