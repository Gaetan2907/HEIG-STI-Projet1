<?php include "../../../databases/db_connection.php"; 
session_start();
include "../../scripts/check_authentication.php";
include "../../scripts/check_is_admin.php";
include "../../scripts/csrf_token.php";

$sql = $file_db->prepare("SELECT * FROM users WHERE `username` = ?");
$sql->execute([$_GET['username']]);
$user = $sql->fetch();

if(empty($user)){
    header('Location: /views/users/show_users.php');
    die();
}

?>
<!doctype html>
<html>
<?php include "../head.php";?>
<body>
<?php include "../nav.php"; ?>
    <div class="container">
        <h1 class="mt-2">Modification Utilisateur</h1>
        <form action="/controllers/users/update_user.php" method="post">
            <input type="hidden" name="csrf_token" value="<?=generate_token()?>" />
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?=$user['username']?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" <?=$user['is_admin'] ? "checked" : ""?>>
                <label class="form-check-label" for="is_admin">Admin</label>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
        <br>
        <form action="/controllers/users/delete_user.php" method="post">
            <input type="hidden" name="csrf_token" value="<?=generate_token()?>" />
            <input type="hidden" name="username" value="<?=$user['username']?>">

            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
<?php include "../scripts.php";?>
</body>
</html>
