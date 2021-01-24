<?php
include "../../../databases/db_connection.php";
session_start();
include "../../scripts/check_authentication.php";

$auth_user = $_SESSION['user'];
?>
<!doctype html>
<html>
<?php include "../head.php";?>
<body>
<?php include "../nav.php"; ?>
    <div class="container">
        <h1 class="mt-2">Mes messages</h1>
        <a href="./new_message.php" class="btn btn-success my-2">Nouveau message</a>
        <?php
        $sql = $file_db->prepare("SELECT * FROM messages WHERE `to` = ? ORDER BY `time` DESC");
        $sql->execute([$auth_user]);
        foreach ($sql->fetchAll() as $message) {
            ?>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=(htmlspecialchars($message['reply_id'])? 'RE: ' : '').htmlspecialchars($message['subject'])?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?=htmlspecialchars($message['from'])?> - <?=date('d F Y H:i', htmlspecialchars($message['time']))?></h6>
                            <p class="card-text collapse" id="collapseContent<?=htmlspecialchars($message['id'])?>"><?=htmlspecialchars($message['content'])?></p>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary show-btn"
                                    data-toggle="collapse"
                                    data-target="#collapseContent<?=$message['id']?>"
                                    aria-expanded="false"
                                    aria-controls="collapseContent<?=$message['id']?>">Lire</button>
                            <a href="./reply_message.php?id=<?=$message['id']?>" class="btn btn-primary">Répondre</a>
                            <a href="/controllers/messages/delete_message.php?id=<?=$message['id']?>"
                               class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php include "../scripts.php";?>
<script>
  // change the text of the collapse btn
  $('.show-btn').click(function(){
    $(this).text(function(i,old){
      return old==='Lire' ?  'Cacher' : 'Lire';
    });
  });
</script>
</body>
</html>
