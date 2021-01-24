<?php
session_start();
include "../../../databases/db_connection.php";
include "../../scripts/csrf_token.php";
$query = $file_db->prepare("SELECT * FROM messages WHERE id = ?");
$query->execute([$_GET['id']]);
$message = $query->fetch();

// gestion des erreurs
// récupération de l'ancienne valeur
$errors = null;
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $content = $_SESSION['old_post']['content'];
}

// vérifie si le champ est valide
function printValidity($field_name) {
    global $errors;
    return isset($errors) && in_array($field_name, $errors) ? 'is-invalid' : 'is-valid';
}
?>
<!doctype html>
<html>
<?php include "../head.php";?>
<body>
<?php include "../nav.php"; ?>
<div class="container">
    <h1>Réponse au message de <?=$message['from']?></h1>
    <div class="row">
        <div class="col">
            <form action="/controllers/messages/reply_message.php" method="post">
                <input type="hidden" name="csrf_token" value="<?=generate_token()?>" />
                <input type="hidden" name="id" value="<?=$message['id']?>">
                <div class="form-group">
                    <label for="content">RE: <?=$message['subject']?></label>
                    <textarea name="content"
                              id="content"
                              class="form-control <?=isset($errors)? printValidity('content') : ''?>"
                              rows="3"
                              required><?=$content?></textarea>
                    <div class="invalid-feedback">
                        Le corps du message ne peut pas être vide
                    </div>
                </div>
                <button class="btn btn-success">Envoyer</button>
            </form>
        </div>
    </div>
</div>
<?php include "../scripts.php";?>
</body>
</html>
