<?php
require __DIR__ . '/config.php';
$id = preg_replace('/[^a-f0-9]/', '', $_GET['id'] ?? '');
$stmt = db()->prepare('SELECT * FROM wishes WHERE slug = ? LIMIT 1');
$stmt->execute([$id]); $wish = $stmt->fetch();
if (!$wish) { http_response_code(404); ?><!doctype html><meta charset="utf-8"><link rel="stylesheet" href="style.css"><main class="wrap"><section class="panel"><h1>Wish not found</h1><a class="btn" href="index.php">Create a wish</a></section></main><?php exit; }
$en = $wish['lang']==='en';
$occasionNames = [
'birthday'=>['bn'=>'শুভ জন্মদিন','en'=>'Happy Birthday'],'love'=>['bn'=>'ভালোবাসা রইল','en'=>'With Love'],
'anniversary'=>['bn'=>'শুভ বিবাহবার্ষিকী','en'=>'Happy Anniversary'],'friendship'=>['bn'=>'বন্ধুত্বের জন্য','en'=>'For a wonderful friend'],
'eid'=>['bn'=>'ঈদ মোবারক','en'=>'Eid Mubarak'],'congrats'=>['bn'=>'অভিনন্দন','en'=>'Congratulations'],
'thanks'=>['bn'=>'অনেক ধন্যবাদ','en'=>'Thank You'],'custom'=>['bn'=>'বিশেষ শুভেচ্ছা','en'=>'A Special Wish']];
$heading = $occasionNames[$wish['occasion']][$en?'en':'bn'] ?? 'A Special Wish';
$url = site_url('wish.php?id='.$wish['slug']);
?>
<!doctype html><html lang="<?= $en?'en':'bn' ?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= esc($heading) ?> · WishMaker</title><link rel="stylesheet" href="style.css"></head>
<body class="wish-page"><main class="wrap"><header class="top"><a class="brand" href="index.php">✦ Wish<span>Maker</span></a><a href="index.php?lang=<?= $en?'en':'bn' ?>"><?= $en?'Create your own':'নিজের উইশ তৈরি করুন' ?></a></header>
<section class="wish-card theme-<?= esc($wish['theme']) ?>"><div class="spark">✦　♡　✧</div><div class="eyebrow"><?= $en?'A LITTLE SOMETHING FOR YOU':'তোমার জন্য ছোট্ট একটি উপহার' ?></div><h1><?= esc($heading) ?>, <span><?= esc($wish['recipient']) ?></span>!</h1><div class="heart">♡</div><p class="message"><?= nl2br(esc($wish['message'])) ?></p><?php if($wish['sender']!==''): ?><p class="sender"><?= $en?'With love,':'ইতি,' ?><br><strong><?= esc($wish['sender']) ?></strong></p><?php endif; ?><?php if($wish['music_hint']): ?><p class="small">♫ <?= $en?'Add your favorite song while sharing':'শেয়ার করার সময় পছন্দের গান যোগ করতে পারো' ?></p><?php endif; ?><div class="spark">✧　♡　✦</div></section>
<section class="share panel"><h2><?= $en?'Share this wish':'উইশটি শেয়ার করুন' ?></h2><p><?= $en?'Copy this unique link and send it to someone special.':'এই আলাদা লিংকটি কপি করে প্রিয়জনকে পাঠিয়ে দাও।' ?></p><input id="wishlink" readonly value="<?= esc($url) ?>"><button class="btn" onclick="copyLink()"><?= $en?'Copy link':'লিংক কপি করুন' ?></button><button class="btn secondary" onclick="shareWish()"><?= $en?'Share':'শেয়ার করুন' ?></button><p id="copystatus" class="small" aria-live="polite"></p><a href="index.php?lang=<?= $en?'en':'bn' ?>"><?= $en?'Make another wish':'আরেকটি উইশ তৈরি করুন' ?></a></section>
<footer>© <?= date('Y') ?> WishMaker · Made with ♡</footer></main><script>
async function copyLink(){const el=document.getElementById('wishlink');try{await navigator.clipboard.writeText(el.value);document.getElementById('copystatus').textContent='Copied!';}catch(e){el.select();document.execCommand('copy');document.getElementById('copystatus').textContent='Link selected/copied.';}}
async function shareWish(){const data={title:document.title,text:'A special wish for you',url:document.getElementById('wishlink').value};if(navigator.share){try{await navigator.share(data)}catch(e){}}else{copyLink()}}
</script></body></html>
