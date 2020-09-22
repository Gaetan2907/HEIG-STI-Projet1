<?php
session_start();
include "../../../databases/db_connection.php";
$_SESSION['errors'] = [];
$_SESSION['old_post'] = $_POST;
$auth_user = 'TheSnekySnek'; // TODO: change for the real authenticated user
if (empty($_POST['id']))
    $_SESSION['errors'][] = 'id';
else {
    $query = $file_db->prepare("SELECT COUNT(*) FROM messages WHERE id = ? AND `to` = ?");
    $query->execute([$_POST['id'], $auth_user]);
    // if user not found
    if ($query->fetchColumn() != 1) $_SESSION['errors'][] = 'id';
}
if (empty($_POST['content'])) $_SESSION['errors'][] = 'content';

if (sizeof($_SESSION['errors']) > 0) {
    echo "error";
    header('Location: /views/messages/reply_message.php?id='.$_POST['id']);
    exit;
} else {
    $_SESSION['errors'] = null;
    // get previous message
    $query = $file_db->prepare("SELECT * FROM messages WHERE id = ?");
    $query->execute([$_POST['id']]);
    $message = $query->fetch();

    // send the new message
    $query = $file_db->prepare("INSERT INTO messages (subject, content, `time`, `from`, `to`, reply_id) VALUES (?, ?, ?, ?, ?, ?)");
    $query->execute([
        $message['subject'],
        $_POST['content'],
        time(),
        $auth_user,
        $message['from'],
        $message['id']
    ]);
    header("Location: /views/messages/messages.php");
    exit;
}
