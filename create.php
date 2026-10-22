<?php
require __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$allowed = ['birthday','love','anniversary','friendship','eid','congrats','thanks','custom'];
$themes = ['rose','gold','ocean','sunshine'];
$type = $_POST['type'] ?? 'custom';
$theme = $_POST['theme'] ?? 'rose';
$recipient = trim($_POST['recipient'] ?? '');
$sender = trim($_POST['sender'] ?? '');
$message = trim($_POST['message'] ?? '');
$lang = (($_POST['lang'] ?? 'bn') === 'en') ? 'en' : 'bn';
if (!in_array($type,$allowed,true) || !in_array($theme,$themes,true) || $recipient==='' || $message==='') {
    http_response_code(400); exit('Please fill the required fields and try again.');
}
if (mb_strlen($recipient)>80 || mb_strlen($sender)>80 || mb_strlen($message)>1500) { http_response_code(400); exit('Text is too long.'); }
$slug = bin2hex(random_bytes(8));
try {
    $stmt = db()->prepare('INSERT INTO wishes (slug, occasion, recipient, sender, message, theme, lang, music_hint, created_at) VALUES (?,?,?,?,?,?,?,?,NOW())');
    $stmt->execute([$slug,$type,$recipient,$sender,$message,$theme,$lang,isset($_POST['music'])?1:0]);
    header('Location: wish.php?id=' . urlencode($slug) . '&created=1'); exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><meta charset="utf-8"><link rel="stylesheet" href="style.css"><main class="wrap"><section class="panel"><h2>Could not save your wish</h2><p>Check that your database details are correct and that you imported schema.sql in phpMyAdmin.</p><a class="btn" href="index.php">Go back</a></section></main>';
}
