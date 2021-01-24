<?php include "../../../databases/db_connection.php"; ?>

<?php

// Retrieve POST parameters
$user = $_POST['username'];
$password = $_POST['password'];

// Retrieve password associated with user
$sql = $file_db->prepare("SELECT * FROM users WHERE `username` = ?");
$sql->execute([$user]);
$db_user = $sql->fetch();

// Check if passwords match
if( !empty($db_user) && $db_user['is_active'] && password_verify($password, $db_user['password'])){
    // Start a new session for this user
    session_start();
    $_SESSION["user"] = $db_user['username'];
    $_SESSION["admin"] = $db_user['is_admin'];
    header('Location: /views/messages/messages.php');
}
else {
    // Go back to the login page
    header('Location: /views/users/login.php');
    echo("Invalid user");
}


?>
