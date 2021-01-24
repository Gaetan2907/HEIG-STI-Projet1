<?php include "../../scripts/csrf_token.php" ?>
<!doctype html>
<html>
<?php include "../head.php"; ?>
<body>
<?php include "../nav.php"; ?>
    <div class="container">
        <h1 class="mt-2">Changer de mot de passe</h1>

        <form action="/controllers/users/change_password.php" method="post">
            <input type="hidden" name="csrf_token" value="<?=generate_token()?>" />
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
        
    </div>
<?php include "../scripts.php";?>
</body>
</html>
