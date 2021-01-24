<?php
session_start();

include "../../scripts/csrf_token.php";

// gestion des messages d'erreur
// récupération des anciennes valeurs
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $sendTo = $_SESSION['old_post']['sendTo'];
    $subject = $_SESSION['old_post']['subject'];
    $content = $_SESSION['old_post']['content'];
    $_SESSION['errors'] = null;
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
        <h1>Nouveau message</h1>
        <div class="row">
            <div class="col">
                <form action="/controllers/messages/store_message.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?=generate_token()?>" />
                    <div class="form-group">
                        <label for="sendTo">Pseudo a contacter</label>
                        <input type="text"
                               class="form-control <?=!empty($errors) ? printValidity('sendTo') : ''?>"
                               id="sendTo"
                               name="sendTo"
                               required
                               value="<?=$sendTo?>">
                        <div class="invalid-feedback">
                            Ce champ doit contenir un pseudo valable
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text"
                               class="form-control <?=isset($errors)? printValidity('subject') : ''?>"
                               id="subject"
                               name="subject"
                               required
                               value="<?=$subject?>">
                        <div class="invalid-feedback">
                            Le sujet du message ne peut pas être vide
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Contenu</label>
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
