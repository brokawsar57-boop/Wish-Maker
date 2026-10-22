<?php
require __DIR__ . '/config.php';
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'en') ? 'en' : 'bn';
$types = [
 'birthday' => ['bn'=>'জন্মদিন','en'=>'Birthday'],
 'love' => ['bn'=>'ভালোবাসা','en'=>'Love'],
 'anniversary' => ['bn'=>'বিবাহবার্ষিকী','en'=>'Anniversary'],
 'friendship' => ['bn'=>'বন্ধুত্ব','en'=>'Friendship'],
 'eid' => ['bn'=>'ঈদ','en'=>'Eid'],
 'congrats' => ['bn'=>'অভিনন্দন','en'=>'Congratulations'],
 'thanks' => ['bn'=>'ধন্যবাদ','en'=>'Thank you'],
 'custom' => ['bn'=>'নিজস্ব শুভেচ্ছা','en'=>'Custom wish']
];
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="<?= $lang ?>">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $lang==='bn'?'Premium Wish Maker':'Premium Wish Maker' ?></title>
<link rel="stylesheet" href="style.css">
</head><body>
<header class="top"><a class="brand" href="index.php">✦ Wish<span>Maker</span></a><nav><a href="index.php?lang=bn">বাংলা</a><a href="index.php?lang=en">English</a><a href="admin.php">Admin</a></nav></header>
<main class="wrap">
<section class="hero"><div class="eyebrow">✧ YOUR MOMENT, YOUR MESSAGE ✧</div>
<h1><?= $lang==='bn'?'মনের কথা হোক সুন্দর একটি উইশে':'Turn your feelings into a beautiful wish' ?></h1>
<p><?= $lang==='bn'?'নাম, বার্তা ও ডিজাইন বেছে নিন। আপনার উইশের আলাদা লিংক তৈরি করে প্রিয়জনের সঙ্গে শেয়ার করুন।':'Personalize a greeting, save it, and share its unique link with someone special.' ?></p>
<div class="pills"><span>♡ Animated cards</span><span>✦ Shareable links</span><span>বাংলা + English</span></div></section>
<section class="panel"><h2><?= $lang==='bn'?'নতুন উইশ তৈরি করুন':'Create a new wish' ?></h2>
<form action="create.php" method="post">
<input type="hidden" name="lang" value="<?= h($lang) ?>">
<label><?= $lang==='bn'?'উইশের ধরন':'Occasion' ?><select name="type"><?php foreach($types as $key=>$label): ?><option value="<?= h($key) ?>"><?= h($label[$lang]) ?></option><?php endforeach; ?></select></label>
<div class="two"><label><?= $lang==='bn'?'যার জন্য':'Recipient name' ?><input name="recipient" maxlength="80" required placeholder="<?= $lang==='bn'?'যেমন: সুমাইয়া':'e.g. Sumaiya' ?>"></label><label><?= $lang==='bn'?'আপনার নাম (ঐচ্ছিক)':'Your name (optional)' ?><input name="sender" maxlength="80" placeholder="<?= $lang==='bn'?'আপনার নাম':'Your name' ?>"></label></div>
<label><?= $lang==='bn'?'শুভেচ্ছা বার্তা':'Wish message' ?><textarea name="message" maxlength="1500" rows="4" required placeholder="<?= $lang==='bn'?'আপনার মনের কথা লিখুন...':'Write your message...' ?>"></textarea></label>
<label><?= $lang==='bn'?'ডিজাইন বেছে নিন':'Choose a design' ?><select name="theme"><option value="rose">Rose Romance</option><option value="gold">Midnight Gold</option><option value="ocean">Ocean Dream</option><option value="sunshine">Sunshine</option></select></label>
<label class="check"><input type="checkbox" name="music" value="1"> <?= $lang==='bn'?'কার্ডে মিউজিক আইকন দেখান (অডিও নিজে যুক্ত করতে হবে)':'Show music hint (audio must be added separately)' ?></label>
<button class="btn" type="submit"><?= $lang==='bn'?'উইশ তৈরি ও সংরক্ষণ করুন':'Create and save wish' ?> ↗</button>
<p class="small"><?= $lang==='bn'?'আপনার উইশ ডেটাবেসে সংরক্ষিত হবে এবং আলাদা শেয়ার লিংক তৈরি হবে।':'Your wish will be saved to the database and receive a unique share link.' ?></p>
</form></section>
<section class="features"><article><b>01 / PERSONAL</b><h3><?= $lang==='bn'?'আপনার মতো করে':'Make it personal' ?></h3><p><?= $lang==='bn'?'নাম ও নিজের বার্তা যোগ করুন।':'Add names and your own message.' ?></p></article><article><b>02 / SAVE</b><h3><?= $lang==='bn'?'নিরাপদে সংরক্ষণ':'Saved for sharing' ?></h3><p><?= $lang==='bn'?'একটি অনন্য লিংক পান।':'Get a unique link to share.' ?></p></article><article><b>03 / SHARE</b><h3><?= $lang==='bn'?'সহজে শেয়ার':'Share with ease' ?></h3><p><?= $lang==='bn'?'WhatsApp, Messenger বা Telegram-এ পাঠান।':'Send through your favorite apps.' ?></p></article></section>
<footer>© <?= date('Y') ?> WishMaker · Made with ♡</footer>
</main></body></html>
